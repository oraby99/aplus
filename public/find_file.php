<?php
$files = scandir(__DIR__ . '/../storage/app/public/projects');
echo "storage/app/public/projects: " . implode(', ', $files) . "<br>";

$files2 = @scandir(__DIR__ . '/../storage/app/private/projects');
if ($files2) echo "storage/app/private/projects: " . implode(', ', $files2) . "<br>";

$files3 = scandir(__DIR__ . '/storage/projects');
echo "public/storage/projects: " . implode(', ', $files3) . "<br>";
