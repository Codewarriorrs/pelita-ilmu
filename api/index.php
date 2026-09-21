<?php

// Tandai bahwa aplikasi berjalan di Vercel
$_ENV['VERCEL'] = '1';
putenv('VERCEL=1');

// Buat direktori /tmp untuk kebutuhan cache & views Laravel di serverless Vercel
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Arahkan cache internal bootstrap ke /tmp
putenv('APP_SERVICES_CACHE=/tmp/storage/bootstrap/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/storage/bootstrap/cache/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/storage/bootstrap/cache/config.php');
putenv('APP_ROUTES_CACHE=/tmp/storage/bootstrap/cache/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/storage/bootstrap/cache/events.php');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// Forward request ke index Laravel utama
require __DIR__ . '/../public/index.php';
