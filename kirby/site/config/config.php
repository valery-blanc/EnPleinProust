<?php

// Detect HTTPS behind Traefik / reverse proxy via X-Forwarded-Proto header
if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

$scheme = ($_SERVER['HTTPS'] ?? '') === 'on' ? 'https' : 'http';
$host   = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';

// SMTP config from environment variables (set in .env on Avignon, never committed)
$smtpHost = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST') ?: '';
$smtpPort = (int)($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: 587);
$smtpUser = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER') ?: '';
$smtpPass = $_ENV['SMTP_PASS'] ?? getenv('SMTP_PASS') ?: '';
$smtpFrom = $_ENV['SMTP_FROM'] ?? getenv('SMTP_FROM') ?: '24hdeproust@gmail.com';

$emailConfig = $smtpHost !== '' ? [
    'transport' => [
        'type'       => 'smtp',
        'host'       => $smtpHost,
        'port'       => $smtpPort,
        'security'   => $smtpPort === 465 ? 'ssl' : 'tls',
        'auth'       => true,
        'username'   => $smtpUser,
        'password'   => $smtpPass,
    ],
] : [];

return [
    'url'      => $scheme . '://' . $host,
    'debug'    => true,
    'panel'    => [
        'install' => true,
    ],
    'languages' => false,
    'locale' => 'fr_FR.utf8',
    'thumbs' => [
        'driver'  => 'gd',
        'quality' => 85,
        'format'  => 'webp',
    ],
    'enpleinproust' => [
        'smtp.from'  => $smtpFrom,
        'csv.path'   => '/data/inscriptions/inscriptions.csv',
    ],
    'email' => $emailConfig,
    'cache' => [
        'pages' => [
            'active' => false,
            'ignore' => fn($page) => in_array($page->intendedTemplate()->name(), ['inscription']),
        ],
    ],
];
