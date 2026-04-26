<?php

use Kirby\Cms\App;
use Kirby\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

App::plugin('enpleinproust/admin', [
    'areas' => [
        'enpleinproust' => function () {
            return [
                'label' => 'En Plein Proust',
                'icon' => 'download',
                'menu' => false,
                'views' => [
                    [
                        'pattern' => 'plugins/enpleinproust/export-xlsx',
                        'action'  => function () {
                            $kirby = kirby();
                            if (!$kirby->user()) {
                                return go('/panel/login');
                            }

                            $parent = $kirby->page('inscriptions');
                            $rows = [];

                            if ($parent) {
                                foreach ($parent->children()->sortBy('dateInscription', 'desc') as $i) {
                                    $rows[] = [
                                        'date'      => $i->dateInscription()->toDate('d/m/Y H:i'),
                                        'prenom'    => $i->prenom()->value(),
                                        'nom'       => $i->nom()->value(),
                                        'email'     => $i->email()->value(),
                                        'telephone' => $i->telephone()->value(),
                                        'creneaux'  => $i->creneaux()->value(),
                                        'message'   => $i->message()->value(),
                                        'statut'    => $i->statut()->value(),
                                    ];
                                }
                            }

                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            $sheet->setTitle('Inscriptions');

                            $headers = ['Date', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Créneaux', 'Message', 'Statut'];
                            foreach ($headers as $i => $h) {
                                $sheet->setCellValueByColumnAndRow($i + 1, 1, $h);
                                $sheet->getStyleByColumnAndRow($i + 1, 1)->getFont()->setBold(true);
                            }

                            foreach ($rows as $r => $row) {
                                $col = 1;
                                foreach ($row as $value) {
                                    $sheet->setCellValueByColumnAndRow($col++, $r + 2, $value);
                                }
                            }

                            for ($c = 1; $c <= count($headers); $c++) {
                                $sheet->getColumnDimensionByColumn($c)->setAutoSize(true);
                            }

                            $writer = new Xlsx($spreadsheet);
                            ob_start();
                            $writer->save('php://output');
                            $body = ob_get_clean();

                            $filename = 'inscriptions-enpleinproust-' . date('Ymd-His') . '.xlsx';

                            return new Response($body, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 200, [
                                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                                'Cache-Control' => 'no-store',
                            ]);
                        }
                    ]
                ]
            ];
        }
    ]
]);
