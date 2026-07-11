<?php
$publicStoragePath = __DIR__ . '/storage';

if (is_link($publicStoragePath) || is_dir($publicStoragePath)) {
    if (PHP_OS_FAMILY === 'Windows') {
        exec('rmdir "' . $publicStoragePath . '"');
    } else {
        unlink($publicStoragePath);
    }
}
echo "Removed public/storage junction.<br>";
