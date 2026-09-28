<?php
if (isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL'])) {
    $dir = '/tmp/storage/framework/views';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}
require __DIR__ . '/../public/index.php';
