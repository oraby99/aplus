<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$page = new \App\Filament\Resources\AcademyInfoResource\Pages\EditAcademyInfo();
// Use reflection to call protected method
$reflection = new ReflectionClass($page);
$method = $reflection->getMethod('getRedirectUrl');
$method->setAccessible(true);
try {
    $url = $method->invoke($page);
    echo "Redirect URL: " . $url;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
