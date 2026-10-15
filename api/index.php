<?php

// Ensure cache paths are directed to writable /tmp directory
$tmpDir = '/tmp';
$storageDir = '/tmp/storage';

$cacheVars = [
    'APP_CONFIG_CACHE' => $tmpDir . '/config.php',
    'APP_EVENTS_CACHE' => $tmpDir . '/events.php',
    'APP_PACKAGES_CACHE' => $tmpDir . '/packages.php',
    'APP_ROUTES_CACHE' => $tmpDir . '/routes.php',
    'APP_SERVICES_CACHE' => $tmpDir . '/services.php',
    'VIEW_COMPILED_PATH' => $storageDir . '/framework/views',
];

foreach ($cacheVars as $key => $val) {
    if (!isset($_ENV[$key])) {
        $_ENV[$key] = $val;
    }
    if (!isset($_SERVER[$key])) {
        $_SERVER[$key] = $val;
    }
    putenv("{$key}={$val}");
}

// Create necessary writable directories in /tmp
$dirs = [
    $storageDir,
    $storageDir . '/app',
    $storageDir . '/app/public',
    $storageDir . '/framework',
    $storageDir . '/framework/cache',
    $storageDir . '/framework/cache/data',
    $storageDir . '/framework/sessions',
    $storageDir . '/framework/views',
    $storageDir . '/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

require __DIR__ . '/../public/index.php';

