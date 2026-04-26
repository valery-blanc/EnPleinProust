<?php

require __DIR__ . '/vendor/autoload.php';

echo (new Kirby\Cms\App([
    'roots' => [
        'index'   => __DIR__,
        'base'    => __DIR__,
        'site'    => __DIR__ . '/site',
        'content' => __DIR__ . '/content',
        'storage' => __DIR__ . '/storage',
    ]
]))->render();
