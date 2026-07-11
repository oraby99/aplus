<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$project = \App\Models\Project::first();
echo "Image Path: " . $project->image_path . "<br>";
