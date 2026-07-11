<?php
$welcomePath = __DIR__ . '/../resources/views/welcome.blade.php';
$welcome = file_get_contents($welcomePath);

// 1. Fix Why Choose Us cards (bg-slate-800 -> bg-white)
$welcome = str_replace('feature-card bg-slate-800', 'feature-card bg-white', $welcome);

// 2. Fix Learning Path (bg-slate-800 -> bg-white, text-slate-800 -> text-white for title)
$welcome = str_replace('<h3 class="text-4xl md:text-5xl font-bold mb-16 text-slate-800">مسار التعلم (Learning Path)</h3>', '<h3 class="text-4xl md:text-5xl font-bold mb-16 text-white">مسار التعلم (Learning Path)</h3>', $welcome);
$welcome = str_replace('bg-slate-800/10', 'bg-white/10', $welcome);
$welcome = str_replace('bg-slate-800/20', 'bg-white/20', $welcome);
$welcome = preg_replace('/w-24 h-24 bg-slate-800/i', 'w-24 h-24 bg-white', $welcome);
$welcome = str_replace('bg-slate-800 rounded-3xl p-8 max-w-lg w-full relative z-10 text-white', 'bg-white rounded-3xl p-8 max-w-lg w-full relative z-10 text-slate-800', $welcome);
$welcome = str_replace('<div class="bg-slate-950 rounded-xl p-4 mb-6">', '<div class="bg-sky-50 rounded-xl p-4 mb-6 border border-sky-200">', $welcome);
$welcome = str_replace('<p class="font-bold text-white mb-2">مدة الكورس', '<p class="font-bold text-slate-800 mb-2">مدة الكورس', $welcome);
$welcome = str_replace('<p class="font-bold text-white">السعر', '<p class="font-bold text-slate-800">السعر', $welcome);

// 3. Fix Instructors
$welcome = str_replace('bg-slate-950 rounded-3xl p-8 flex flex-col', 'bg-white rounded-3xl p-8 flex flex-col', $welcome);

// 4. Fix Student Projects
$welcome = str_replace('<h3 class="text-4xl md:text-5xl font-bold mb-16 text-white">مشاريع الطلاب</h3>', '<h3 class="text-4xl md:text-5xl font-bold mb-16 text-slate-800">مشاريع الطلاب</h3>', $welcome);
$welcome = str_replace('bg-slate-800 flex items-center', 'bg-white flex items-center', $welcome);
$welcome = str_replace('rounded-3xl bg-slate-800', 'rounded-3xl bg-white border border-sky-200', $welcome);

// 5. Fix Competitions
$welcome = str_replace('bg-slate-800 rounded-3xl p-8 shadow-xl', 'bg-white rounded-3xl p-8 shadow-xl', $welcome);
$welcome = str_replace('bg-slate-950 p-4 rounded-xl', 'bg-sky-50 p-4 rounded-xl', $welcome);

// 6. Fix Testimonials
$welcome = str_replace('bg-slate-950 p-8 rounded-3xl shadow-lg', 'bg-white p-8 rounded-3xl shadow-lg', $welcome);
$welcome = str_replace('<h5 class="font-bold text-white">', '<h5 class="font-bold text-slate-800">', $welcome);

// 7. Fix Game
$welcome = str_replace('<h2 class="text-secondary font-bold mb-2">وقت المرح!</h2>
        <h3 class="text-4xl md:text-5xl font-bold text-white mb-8">لعبة صائد الأخطاء البرمجية (Bugs)</h3>
        <p class="text-lg text-white max-w-3xl mx-auto mb-12">', '<h2 class="text-secondary font-bold mb-2">وقت المرح!</h2>
        <h3 class="text-4xl md:text-5xl font-bold text-slate-800 mb-8">لعبة صائد الأخطاء البرمجية (Bugs)</h3>
        <p class="text-lg text-slate-600 max-w-3xl mx-auto mb-12">', $welcome);
$welcome = str_replace('bg-slate-800 rounded-3xl p-4 md:p-8', 'bg-slate-900 rounded-3xl p-4 md:p-8', $welcome); // Keep game board dark

// Fix body overflow-x-hidden in app.blade.php
$appPath = __DIR__ . '/../resources/views/layouts/app.blade.php';
$app = file_get_contents($appPath);
$app = str_replace('<body class="font-cairo text-right antialiased bg-slate-900 text-slate-300">', '<body class="font-cairo text-right antialiased bg-sky-50 text-slate-600 overflow-x-hidden">', $app);
// Also in case it was already changed by previous script
$app = preg_replace('/<body class="([^"]*)bg-sky-50([^"]*)">/i', '<body class="$1bg-sky-50$2 overflow-x-hidden">', $app);
$app = str_replace('overflow-x-hidden overflow-x-hidden', 'overflow-x-hidden', $app);

// Fix footer colors
$app = str_replace('text-slate-500 hover:text-white', 'text-slate-600 hover:text-blue-600', $app);
$app = str_replace('<footer class="bg-white text-slate-800 border-t border-sky-100 mt-20 relative z-20">', '<footer class="bg-white text-slate-800 border-t border-sky-100 mt-20 relative z-20">', $app); // Ensuring it's white
// Ensure footer links are dark enough
$app = str_replace('text-slate-400', 'text-slate-600', $app);

file_put_contents($welcomePath, $welcome);
file_put_contents($appPath, $app);

echo "All layout issues fixed!";
