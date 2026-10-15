<?php

// Turn on error reporting so PHP doesn't silently crash
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Quick diagnostic endpoint
if (isset($_GET['diag'])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== VERCEL PHP DIAGNOSTIC ===\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
    echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
    echo "Autoload Exists: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'YES' : 'NO') . "\n";
    echo "Public Index Exists: " . (file_exists(__DIR__ . '/../public/index.php') ? 'YES' : 'NO') . "\n";
    echo "Storage Writable: " . (is_writable('/tmp') ? 'YES' : 'NO') . "\n";
    echo "App Key Set: " . (!empty(getenv('APP_KEY')) || !empty($_ENV['APP_KEY']) || !empty($_SERVER['APP_KEY']) ? 'YES' : 'NO') . "\n";
    echo "DB Host Set: " . (!empty(getenv('DB_HOST')) || !empty($_ENV['DB_HOST']) || !empty($_SERVER['DB_HOST']) ? 'YES' : 'NO') . "\n";
    exit;
}

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

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=utf-8');
        echo "=== FATAL PHP SHUTDOWN ERROR ===\n";
        echo "Type: " . $error['type'] . "\n";
        echo "Message: " . $error['message'] . "\n";
        echo "File: " . $error['file'] . " (Line: " . $error['line'] . ")\n";
    }
});

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== LARAVEL APPLICATION EXCEPTION ===\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString() . "\n";
    exit;
}

