<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $viewPath = storage_path('framework/views');
        if (!is_dir($viewPath)) {
            @mkdir($viewPath, 0775, true);
        }

        // Pastikan view.compiled selalu mengarah ke storage server yang valid
        config(['view.compiled' => $viewPath]);

        // Pastikan seluruh direktori storage esensial otomatis dibuat jika belum ada
        foreach ([
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('logs'),
            storage_path('app/public'),
        ] as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
        }

        // Bersihkan cache usang jika ada cache dari laptop lokal yang ikut ter-upload
        $cacheDir = $this->app->bootstrapPath('cache');
        foreach (['config.php', 'routes-v7.php', 'packages.php', 'services.php'] as $file) {
            $filePath = $cacheDir . '/' . $file;
            if (file_exists($filePath)) {
                $content = @file_get_contents($filePath);
                if ($content && (
                    strpos($content, '/media/zallzall') !== false ||
                    (strpos($content, 'PailServiceProvider') !== false && !class_exists('Laravel\\Pail\\PailServiceProvider')) ||
                    strpos($content, base_path()) === false
                )) {
                    @unlink($filePath);
                }
            }
        }

        // Hapus file public/hot jika ter-upload ke server produksi (agar tidak blank putih)
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $isLocalHost = in_array(parse_url('http://' . $host, PHP_URL_HOST), ['127.0.0.1', 'localhost']);
        if (!$isLocalHost && file_exists(public_path('hot'))) {
            @unlink(public_path('hot'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
