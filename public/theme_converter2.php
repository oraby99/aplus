<?php
function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (str_ends_with($path, '.blade.php')) {
                $results[] = $path;
            }
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
        }
    }
    return $results;
}

$files = getDirContents(__DIR__ . '/../resources/views');

$replacements = [
    'text-slate-900' => 'text-white',
    'text-slate-800' => 'text-white',
    'text-slate-700' => 'text-slate-300',
    'text-slate-600' => 'text-slate-400',
    'bg-white/40' => 'bg-slate-900/40',
    'bg-white/60' => 'bg-slate-900/40',
    'bg-white/70' => 'bg-slate-900/70',
    'bg-white' => 'bg-slate-900/40',
    'bg-slate-50' => 'bg-slate-900/40',
    'bg-slate-100' => 'bg-slate-900/40',
    'from-blue-50/50 via-purple-50/50 to-white/50' => 'from-slate-900/40 via-purple-900/20 to-slate-900/40',
    'bg-yellow-50/40' => 'bg-slate-900/40',
    'bg-indigo-50/40' => 'bg-slate-900/40',
    'bg-gradient-to-b from-white to-blue-50' => 'bg-slate-900/40',
    'bg-gradient-to-br from-indigo-50 to-blue-50' => 'bg-slate-900/40',
    'bg-gradient-to-br from-yellow-50 to-orange-50' => 'bg-slate-900/40',
    'border-blue-100' => 'border-slate-700',
    'border-slate-100' => 'border-slate-700',
    'border-white/50' => 'border-slate-700/50',
    'ring-white/50' => 'ring-slate-700/50',
    'text-slate-500' => 'text-slate-400',
];

foreach ($files as $file) {
    if (strpos($file, 'layouts\app.blade.php') !== false || strpos($file, 'layouts/app.blade.php') !== false) {
        // already converted manually, skip to avoid double replacements issues
        continue; 
    }
    $content = file_get_contents($file);
    foreach ($replacements as $old => $new) {
        $content = str_replace($old, $new, $content);
    }
    file_put_contents($file, $content);
    echo "Updated $file\n<br>";
}
