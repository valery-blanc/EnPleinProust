<?php

return function ($kirby, $page, $site) {
    if ($kirby->request()->is('POST') === false) {
        return [];
    }

    $r = $kirby->request();

    // Honeypot anti-spam
    if (trim((string)$r->body()->get('website')) !== '') {
        return ['success' => true];
    }

    $data = [
        'prenom'        => trim((string)$r->body()->get('prenom')),
        'nom'           => trim((string)$r->body()->get('nom')),
        'email'         => trim((string)$r->body()->get('email')),
        'telephone'     => trim((string)$r->body()->get('telephone')),
        'creneaux'      => array_filter((array)$r->body()->get('creneaux'), fn($v) => $v !== ''),
        'creneauxLibre' => trim((string)$r->body()->get('creneauxLibre')),
        'message'       => trim((string)$r->body()->get('message')),
        'consentementRgpd' => $r->body()->get('consentementRgpd') ? '1' : '0',
    ];

    $errors = [];
    if ($data['prenom'] === '') $errors[] = 'Prénom requis.';
    if ($data['nom'] === '') $errors[] = 'Nom requis.';
    if ($data['email'] === '' || filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'Email invalide.';
    }
    if ($data['consentementRgpd'] !== '1') $errors[] = 'Vous devez accepter les conditions RGPD.';

    $min = $page->minCreneaux()->or(2)->toInt();
    $max = $page->maxCreneaux()->or(4)->toInt();
    $creneauxStructure = $page->creneauxList()->toStructure();
    $hasStructuredCreneaux = $creneauxStructure && $creneauxStructure->count() > 0;

    if ($hasStructuredCreneaux) {
        $count = count($data['creneaux']);
        if ($count < $min || $count > $max) {
            $errors[] = "Sélectionnez entre {$min} et {$max} créneaux.";
        }
    } else {
        if ($data['creneauxLibre'] === '') {
            $errors[] = 'Indiquez vos préférences de créneaux.';
        }
    }

    if ($errors !== []) {
        return ['alert' => implode(' ', $errors), 'data' => $data];
    }

    $parent = $kirby->page('inscriptions');
    if ($parent === null) {
        return [
            'alert' => 'Erreur : page "inscriptions" manquante. Merci de prévenir l\'administrateur·ice.',
            'data'  => $data,
        ];
    }

    $now = new DateTimeImmutable('now');
    $slug = $now->format('Ymd-His') . '-' . substr(preg_replace('/[^a-z0-9]/i', '', strtolower($data['prenom'] . $data['nom'])), 0, 16);
    $creneauxLabel = $hasStructuredCreneaux ? implode(', ', $data['creneaux']) : $data['creneauxLibre'];

    // 1 — Sauvegarder dans Kirby (sous-page de inscriptions/)
    try {
        $kirby->impersonate('kirby');
        $kirby->page('inscriptions')->createChild([
            'slug'     => $slug,
            'template' => 'inscription-entry',
            'content'  => [
                'title'            => $data['prenom'] . ' ' . $data['nom'],
                'prenom'           => $data['prenom'],
                'nom'              => $data['nom'],
                'email'            => $data['email'],
                'telephone'        => $data['telephone'],
                'creneaux'         => $creneauxLabel,
                'message'          => $data['message'],
                'statut'           => 'en-attente',
                'dateInscription'  => $now->format('c'),
                'consentementRgpd' => 'true',
            ],
        ]);
    } catch (\Throwable $e) {
        return ['alert' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage(), 'data' => $data];
    }

    // 2 — Backup CSV hors container
    $csvPath = $kirby->option('enpleinproust.csv.path', '/data/inscriptions/inscriptions.csv');
    try {
        $csvDir = dirname($csvPath);
        if (!is_dir($csvDir)) {
            mkdir($csvDir, 0755, true);
        }
        $isNew = !file_exists($csvPath);
        $fh = fopen($csvPath, 'a');
        if ($fh) {
            if ($isNew) {
                fputcsv($fh, ['date', 'prenom', 'nom', 'email', 'telephone', 'creneaux', 'message', 'statut'], ';');
            }
            fputcsv($fh, [
                $now->format('d/m/Y H:i:s'),
                $data['prenom'],
                $data['nom'],
                $data['email'],
                $data['telephone'],
                $creneauxLabel,
                $data['message'],
                'en-attente',
            ], ';');
            fclose($fh);
        }
    } catch (\Throwable $e) {
        // CSV non écrit : on continue (la sous-page Kirby fait office de backup secondaire)
        error_log('[EnPleinProust] CSV backup failed: ' . $e->getMessage());
    }

    // 3 — Email de confirmation à l'inscrit·e
    $smtpFrom = $kirby->option('enpleinproust.smtp.from', '24hdeproust@gmail.com');

    $tags = [
        '#PRENOM'    => $data['prenom'],
        '#NOM'       => $data['nom'],
        '#EMAIL'     => $data['email'],
        '#TELEPHONE' => $data['telephone'] ?: '-',
        '#CRENEAUX'  => $creneauxLabel,
        '#MESSAGE'   => $data['message'] ?: '-',
    ];

    $confirmSubject = (string)$site->emailConfirmationSujet()->or('Votre inscription à En Plein Proust est bien reçue');
    $confirmBody    = (string)$site->emailConfirmationCorps();

    if ($confirmBody === '') {
        $confirmBody = "Bonjour #PRENOM,\n\nMerci pour votre inscription à En Plein Proust.\n\nCréneaux : #CRENEAUX\n\nÀ bientôt !\n\nL'équipe En Plein Proust";
    }

    $confirmBody = strtr($confirmBody, $tags);
    $confirmSubject = strtr($confirmSubject, $tags);

    try {
        $kirby->email([
            'to'      => $data['email'],
            'from'    => $smtpFrom,
            'replyTo' => $smtpFrom,
            'subject' => $confirmSubject,
            'body'    => $confirmBody,
        ]);
    } catch (\Throwable $e) {
        error_log('[EnPleinProust] Confirmation email failed: ' . $e->getMessage());
    }

    // 4 — Email de notification aux organisateurices
    $destinatairesRaw = (string)$site->emailDestinataires();
    if ($destinatairesRaw !== '') {
        $destinataires = array_filter(array_map('trim', explode(',', $destinatairesRaw)));
        $notifBody = "Nouvelle inscription reçue :\n\n"
            . "Prénom  : {$data['prenom']}\n"
            . "Nom     : {$data['nom']}\n"
            . "Email   : {$data['email']}\n"
            . "Tél.    : " . ($data['telephone'] ?: '-') . "\n\n"
            . "Créneaux :\n  " . str_replace(', ', "\n  ", $creneauxLabel) . "\n\n"
            . "Message :\n" . ($data['message'] ?: '(aucun)') . "\n\n"
            . "→ Panel : " . $kirby->url() . '/panel/pages/inscriptions+' . $slug;

        foreach ($destinataires as $dest) {
            try {
                $kirby->email([
                    'to'      => $dest,
                    'from'    => $smtpFrom,
                    'replyTo' => $data['email'],
                    'subject' => '[En Plein Proust] Nouvelle inscription — ' . $data['prenom'] . ' ' . $data['nom'],
                    'body'    => $notifBody,
                ]);
            } catch (\Throwable $e) {
                error_log('[EnPleinProust] Notification email to ' . $dest . ' failed: ' . $e->getMessage());
            }
        }
    }

    return ['success' => true];
};
