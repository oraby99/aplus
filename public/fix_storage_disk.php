<?php

// 1. Move files from private/projects to public/projects
$privateDir = __DIR__ . '/../storage/app/private/projects';
$publicDir = __DIR__ . '/../storage/app/public/projects';

if (!is_dir($publicDir)) {
    mkdir($publicDir, 0755, true);
}

if (is_dir($privateDir)) {
    $files = scandir($privateDir);
    $movedCount = 0;
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            rename($privateDir . '/' . $file, $publicDir . '/' . $file);
            $movedCount++;
        }
    }
    echo "Moved $movedCount files from private to public.<br>";
} else {
    echo "Private projects dir does not exist.<br>";
}

// 2. Change .env
$envPath = __DIR__ . '/../.env';
$envContent = file_get_contents($envPath);
if (str_contains($envContent, 'FILESYSTEM_DISK=local')) {
    $envContent = str_replace('FILESYSTEM_DISK=local', 'FILESYSTEM_DISK=public', $envContent);
    file_put_contents($envPath, $envContent);
    echo "Updated FILESYSTEM_DISK to public in .env<br>";
} else {
    echo "FILESYSTEM_DISK is already public or not found.<br>";
}

