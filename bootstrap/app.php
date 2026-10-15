<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        $middleware->redirectGuestsTo(fn (\Illuminate\Http\Request $request) => 
            route('login.admin')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
} else {
    // Hapus cache usang jika file cache laptop lokal ikut ter-upload
    $cacheDir = dirname(__DIR__) . '/bootstrap/cache';
    foreach (['config.php', 'routes-v7.php', 'packages.php', 'services.php'] as $file) {
        $filePath = $cacheDir . '/' . $file;
        if (file_exists($filePath)) {
            $content = @file_get_contents($filePath);
            if ($content && (
                strpos($content, '/media/zallzall') !== false ||
                (strpos($content, 'PailServiceProvider') !== false && !class_exists('Laravel\\Pail\\PailServiceProvider')) ||
                strpos($content, dirname(__DIR__)) === false
            )) {
                @unlink($filePath);
            }
        }
    }

    // Hapus file public/hot jika ter-upload ke hosting (bukan localhost) agar tidak blank putih
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $isLocalHost = in_array(parse_url('http://' . $host, PHP_URL_HOST), ['127.0.0.1', 'localhost']);
    if (!$isLocalHost && file_exists(dirname(__DIR__) . '/public/hot')) {
        @unlink(dirname(__DIR__) . '/public/hot');
    }

    foreach ([
        dirname(__DIR__) . '/storage/framework/views',
        dirname(__DIR__) . '/storage/framework/cache/data',
        dirname(__DIR__) . '/storage/framework/sessions',
        dirname(__DIR__) . '/storage/logs',
        dirname(__DIR__) . '/storage/app/public',
    ] as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
    }
}

return $app;
