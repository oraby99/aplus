<?php
$files = glob('c:/Users/DELL/Documents/FREELANCE/A+Academy/app/Filament/Resources/*/Pages/*.php');
$missing = [];
foreach ($files as $path) {
    if (str_contains($path, 'List')) continue;
    
    $content = file_get_contents($path);
    if (!str_contains($content, 'getRedirectUrl')) {
        $missing[] = basename($path);
    }
}
echo "Missing: " . implode(', ', $missing);
