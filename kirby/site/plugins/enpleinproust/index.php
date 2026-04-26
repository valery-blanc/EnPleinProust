<?php

use Kirby\Cms\App;
use Kirby\Http\Response;

App::plugin('enpleinproust/admin', [

    'hooks' => [
        'page.delete:after' => function ($page) {
            if ($page->intendedTemplate()->name() !== 'inscription-entry') {
                return;
            }

            $csvPath = kirby()->option('enpleinproust.csv.path', '/data/inscriptions/inscriptions.csv');
            if (!file_exists($csvPath)) {
                return;
            }

            // Données de la page supprimée pour la retrouver dans le CSV
            $email  = $page->email()->value();
            $prenom = $page->prenom()->value();
            $nom    = $page->nom()->value();

            // Convertir la date ISO stockée dans Kirby au format du CSV (d/m/Y H:i:s)
            $dateForCsv = '';
            try {
                $dt = new DateTimeImmutable((string)$page->dateInscription());
                $dateForCsv = $dt->format('d/m/Y H:i:s');
            } catch (\Throwable $e) {
                // Matching sans la date si conversion impossible
            }

            // Lire le CSV complet
            $rows = [];
            $fh = fopen($csvPath, 'r');
            if (!$fh) return;

            $isHeader = true;
            while (($row = fgetcsv($fh, 0, ';')) !== false) {
                if ($isHeader) {
                    $rows[]   = $row;
                    $isHeader = false;
                    continue;
                }
                // Colonnes : date(0) prenom(1) nom(2) email(3) telephone(4) creneaux(5) message(6) statut(7)
                $matchEmail  = ($row[3] ?? '') === $email;
                $matchPrenom = ($row[1] ?? '') === $prenom;
                $matchNom    = ($row[2] ?? '') === $nom;
                $matchDate   = $dateForCsv === '' || ($row[0] ?? '') === $dateForCsv;

                if ($matchEmail && $matchPrenom && $matchNom && $matchDate) {
                    $row[7] = 'Supprimée';
                }
                $rows[] = $row;
            }
            fclose($fh);

            // Réécrire le CSV
            $fh = fopen($csvPath, 'w');
            if ($fh) {
                foreach ($rows as $row) {
                    fputcsv($fh, $row, ';');
                }
                fclose($fh);
            }
        },
    ],

    'areas' => [
        'enpleinproust' => function () {
            return [
                'label' => 'En Plein Proust',
                'icon'  => 'download',
                'menu'  => false,
                'views' => [
                    [
                        'pattern' => 'plugins/enpleinproust/export-csv',
                        'action'  => function () {
                            $kirby = kirby();
                            if (!$kirby->user()) {
                                return go('/panel/login');
                            }

                            $csvPath = $kirby->option('enpleinproust.csv.path', '/data/inscriptions/inscriptions.csv');

                            if (!file_exists($csvPath)) {
                                // Générer depuis les sous-pages Kirby si le fichier n'existe pas
                                $parent = $kirby->page('inscriptions');
                                $rows   = [];

                                if ($parent) {
                                    foreach ($parent->children()->sortBy('dateInscription', 'desc') as $i) {
                                        $rows[] = [
                                            $i->dateInscription()->toDate('d/m/Y H:i'),
                                            $i->prenom()->value(),
                                            $i->nom()->value(),
                                            $i->email()->value(),
                                            $i->telephone()->value(),
                                            $i->creneaux()->value(),
                                            $i->message()->value(),
                                            $i->statut()->value(),
                                        ];
                                    }
                                }

                                ob_start();
                                $fh = fopen('php://output', 'w');
                                fputs($fh, "\xEF\xBB\xBF");
                                fputcsv($fh, ['Date', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Créneaux', 'Message', 'Statut'], ';');
                                foreach ($rows as $row) {
                                    fputcsv($fh, $row, ';');
                                }
                                fclose($fh);
                                $body = ob_get_clean();
                            } else {
                                $raw  = file_get_contents($csvPath);
                                $body = (substr($raw, 0, 3) !== "\xEF\xBB\xBF") ? "\xEF\xBB\xBF" . $raw : $raw;
                            }

                            $filename = 'inscriptions-enpleinproust-' . date('Ymd-His') . '.csv';

                            return new Response($body, 'text/csv; charset=utf-8', 200, [
                                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                                'Cache-Control'       => 'no-store',
                            ]);
                        }
                    ]
                ]
            ];
        }
    ]
]);
