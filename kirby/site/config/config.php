<?php

// Detect HTTPS behind Traefik / reverse proxy via X-Forwarded-Proto header
if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

$scheme = ($_SERVER['HTTPS'] ?? '') === 'on' ? 'https' : 'http';
$host   = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';

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
        'notification.email' => '24hdeproust@gmail.com',
    ],
    'cache' => [
        'pages' => [
            'active' => false,
            'ignore' => fn($page) => in_array($page->intendedTemplate()->name(), ['inscription']),
        ],
    ],
];
