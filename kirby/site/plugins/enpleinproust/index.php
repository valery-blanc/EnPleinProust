<?php

use Kirby\Cms\App;
use Kirby\Http\Response;

App::plugin('enpleinproust/admin', [
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
                                // Générer un CSV depuis les sous-pages Kirby si le fichier n'existe pas encore
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
                                fputs($fh, "\xEF\xBB\xBF"); // BOM UTF-8 pour Excel
                                fputcsv($fh, ['Date', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Créneaux', 'Message', 'Statut'], ';');
                                foreach ($rows as $row) {
                                    fputcsv($fh, $row, ';');
                                }
                                fclose($fh);
                                $body = ob_get_clean();
                            } else {
                                // Retourner le fichier CSV de backup avec BOM si absent
                                $raw = file_get_contents($csvPath);
                                // Ajouter BOM si absent (pour que Excel l'ouvre en UTF-8)
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
