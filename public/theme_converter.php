<?php
// Converter script
$files = [
    __DIR__ . '/../resources/views/welcome.blade.php',
    __DIR__ . '/../resources/views/layouts/app.blade.php'
];

$replacements = [
    'text-slate-900' => 'text-white',
    'text-slate-600' => 'text-slate-300',
    'bg-white/40' => 'bg-slate-900/40',
    'bg-white/60' => 'bg-slate-900/40',
    'bg-white' => 'bg-slate-800',
    'bg-slate-50' => 'bg-slate-950',
    'from-blue-50/50 via-purple-50/50 to-white/50' => 'from-slate-900/40 via-purple-900/20 to-slate-900/40',
    'bg-yellow-50/40' => 'bg-slate-900/40',
    'bg-indigo-50/40' => 'bg-slate-900/40',
    'bg-gradient-to-b from-white to-blue-50' => 'bg-slate-900/40',
    'text-slate-800' => 'text-white',
    'border-blue-100' => 'border-slate-700',
    'border-white/50' => 'border-slate-700/50',
    'ring-white/50' => 'ring-slate-700/50',
    'bg-background' => 'bg-slate-950',
    'text-foreground' => 'text-white',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        foreach ($replacements as $old => $new) {
            // we only replace full words for classes
            $content = str_replace($old, $new, $content);
        }
        file_put_contents($file, $content);
        echo "Updated $file\n<br>";
    }
}
