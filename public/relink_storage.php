<?php
$publicStoragePath = __DIR__ . '/storage';

if (is_link($publicStoragePath) || is_dir($publicStoragePath)) {
    if (PHP_OS_FAMILY === 'Windows') {
        exec('rmdir "' . $publicStoragePath . '"');
    } else {
        unlink($publicStoragePath);
    }
}

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('storage:link');
echo "Deleted old storage link and created new one. Status: " . $status;
