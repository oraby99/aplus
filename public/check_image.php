<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$project = \App\Models\Project::first();
echo "Image Path: " . $project->image_path . "<br>";
echo "Asset URL: " . asset('storage/' . $project->image_path) . "<br>";
echo "Storage URL: " . \Illuminate\Support\Facades\Storage::disk('public')->url($project->image_path) . "<br>";
echo "File Exists in storage/app/public: " . (file_exists(storage_path('app/public/' . $project->image_path)) ? 'Yes' : 'No') . "<br>";
echo "File Exists in public/storage: " . (file_exists(public_path('storage/' . $project->image_path)) ? 'Yes' : 'No') . "<br>";
