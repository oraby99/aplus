<?php
$files = [
    __DIR__ . '/../resources/views/welcome.blade.php',
    __DIR__ . '/../resources/views/courses.blade.php',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Replace dark mode backgrounds with light mode equivalents
    $content = str_replace('bg-slate-900/40', 'bg-sky-50', $content);
    $content = str_replace('bg-slate-900/90', 'bg-sky-100', $content);
    $content = str_replace('bg-slate-900/80', 'bg-slate-800/50', $content); // Modals overlay
    $content = str_replace('bg-slate-900/60', 'bg-white', $content);
    $content = str_replace('bg-slate-900', 'bg-white', $content);
    
    // Replace dark mode borders
    $content = str_replace('border-slate-700', 'border-sky-200', $content);
    $content = str_replace('ring-slate-700/50', 'ring-sky-200', $content);
    
    // Replace dark mode text with light mode text
    $content = str_replace('text-slate-300', 'text-slate-600', $content);
    $content = str_replace('text-slate-400', 'text-slate-500', $content);
    
    // Carefully replace text-white with text-slate-800, but only for headings and paragraphs outside the hero section
    $content = preg_replace('/<h3 class="([^"]*)text-white([^"]*)">/i', '<h3 class="$1text-slate-800$2">', $content);
    $content = preg_replace('/<h4 class="([^"]*)text-white([^"]*)">/i', '<h4 class="$1text-slate-800$2">', $content);
    $content = preg_replace('/<h2 class="([^"]*)text-white([^"]*)">/i', '<h2 class="$1text-slate-800$2">', $content);
    
    file_put_contents($file, $content);
}

// Update app.blade.php footer
$appFile = __DIR__ . '/../resources/views/layouts/app.blade.php';
if (file_exists($appFile)) {
    $appContent = file_get_contents($appFile);
    $appContent = str_replace('<footer class="bg-slate-900 text-white', '<footer class="bg-white text-slate-800 border-t border-sky-100', $appContent);
    $appContent = str_replace('text-slate-400', 'text-slate-500', $appContent);
    $appContent = str_replace('bg-slate-800', 'bg-sky-100', $appContent);
    file_put_contents($appFile, $appContent);
}

echo "Light theme unified successfully.";
