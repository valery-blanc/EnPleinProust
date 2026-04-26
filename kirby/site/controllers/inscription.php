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
    $hasStructuredCreneaux = $page->creneauxList()->toStructure()->count() > 0;

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
        return [
            'alert' => implode(' ', $errors),
            'data'  => $data,
        ];
    }

    $parent = $kirby->page('inscriptions');
    if ($parent === null) {
        return [
            'alert' => 'Erreur : page parente "inscriptions" manquante. Merci de prévenir l\'administrateur·ice.',
            'data'  => $data,
        ];
    }

    $now = new DateTimeImmutable('now');
    $slug = $now->format('Ymd-His') . '-' . substr(preg_replace('/[^a-z0-9]/i', '', strtolower($data['prenom'] . $data['nom'])), 0, 16);

    try {
        $kirby->impersonate('kirby');

        $newPage = $parent->createChild([
            'slug'     => $slug,
            'template' => 'inscription-entry',
            'content'  => [
                'title'           => $data['prenom'] . ' ' . $data['nom'],
                'prenom'          => $data['prenom'],
                'nom'             => $data['nom'],
                'email'           => $data['email'],
                'telephone'       => $data['telephone'],
                'creneaux'        => $hasStructuredCreneaux
                    ? implode(', ', $data['creneaux'])
                    : $data['creneauxLibre'],
                'message'         => $data['message'],
                'statut'          => 'en-attente',
                'dateInscription' => $now->format('c'),
                'consentementRgpd' => 'true',
            ],
        ]);
    } catch (\Throwable $e) {
        return [
            'alert' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage(),
            'data'  => $data,
        ];
    }

    // Notification email à l'organisatrice (best-effort, ne bloque pas en cas d'échec SMTP)
    $notifyTo = $kirby->option('enpleinproust.notification.email', '24hdeproust@gmail.com');
    $creneauxLabel = $hasStructuredCreneaux ? implode("\n  - ", $data['creneaux']) : $data['creneauxLibre'];

    try {
        $kirby->email([
            'to'      => $notifyTo,
            'from'    => $notifyTo,
            'replyTo' => $data['email'],
            'subject' => '[En Plein Proust] Nouvelle inscription — ' . $data['prenom'] . ' ' . $data['nom'],
            'body'    => "Nouvelle inscription :\n\n"
                . "Nom : {$data['prenom']} {$data['nom']}\n"
                . "Email : {$data['email']}\n"
                . "Téléphone : " . ($data['telephone'] ?: '-') . "\n\n"
                . "Créneaux préférés :\n  - {$creneauxLabel}\n\n"
                . "Message :\n" . ($data['message'] ?: '(aucun)') . "\n\n"
                . "→ Voir dans le panel : " . $kirby->url() . "/panel/pages/inscriptions+" . $slug,
        ]);
    } catch (\Throwable $e) {
        // Email non envoyé : log mais continue
        // (en dev, pas de SMTP configuré — c'est normal)
    }

    // Confirmation au lecteurice
    try {
        $kirby->email([
            'to'      => $data['email'],
            'from'    => $notifyTo,
            'replyTo' => $notifyTo,
            'subject' => 'Votre inscription à En Plein Proust est bien reçue',
            'body'    => "Bonjour {$data['prenom']},\n\n"
                . "Merci pour votre inscription à En Plein Proust.\n\n"
                . "Vos préférences de créneaux ont été enregistrées. Nathalie reviendra "
                . "vers vous par email pour vous communiquer votre ordre de passage exact.\n\n"
                . "À bientôt aux Ateliers Mommen !\n\n"
                . "L'équipe En Plein Proust",
        ]);
    } catch (\Throwable $e) {
        // OK
    }

    return ['success' => true];
};
