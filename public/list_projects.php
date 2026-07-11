<?php
$dir = __DIR__ . '/../storage/app/public/projects';
if (is_dir($dir)) {
    $files = scandir($dir);
    echo implode('<br>', $files);
} else {
    echo "Directory does not exist.";
}
