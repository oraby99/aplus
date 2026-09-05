<?php

use Illuminate\Support\Facades\Route;

use App\Models\Course;
use App\Models\Project;
use App\Models\User;
use App\Models\Competition;

Route::get('/', function () {
    $courses = Course::with('levels')->get();
    $projects = Project::with(['student', 'course'])->latest()->take(6)->get();
    $teachers = User::where('type', 'teacher')->get();
    $competitions = Competition::where('status', '!=', 'completed')->latest()->get();
    // Fetch approved testimonials
    $testimonials = \App\Models\Testimonial::where('is_approved', true)->latest()->take(6)->get();
    // Keep old evaluations as fallback if no testimonials exist yet
    $evaluations = \App\Models\Evaluation::with(['student', 'course'])->where('score', '>=', 80)->latest()->take(4)->get();
    
    return view('welcome', compact('courses', 'projects', 'teachers', 'competitions', 'testimonials', 'evaluations'));
});

Route::get('/courses', function () {
    $courses = Course::with('levels')->get();
    return view('courses', compact('courses'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'message' => 'required'
    ]);
    
    \App\Models\ContactMessage::create($request->all());
    
    return redirect('/contact')->with('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');
});

// Windows PHP built-in server symlink workaround
if (app()->environment('local')) {
    Route::get('/storage/{path}', function ($path) {
        $filePath = storage_path('app/public/' . $path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->file($filePath);
    })->where('path', '.*');
}

Route::post('/testimonials', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'course_name' => 'nullable|string|max:255',
        'score' => 'required|integer|min:1|max:5',
        'feedback' => 'required|string'
    ]);
    
    \App\Models\Testimonial::create([
        'name' => $request->name,
        'course_name' => $request->course_name,
        'score' => $request->score,
        'feedback' => $request->feedback,
        'is_approved' => false,
    ]);
    
    return redirect('/#testimonials-section')->with('testimonial_success', 'تم إرسال تقييمك بنجاح! سيتم مراجعته وعرضه قريباً. شكراً لك.');
});
Route::get('/generate-filament', function () {
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'TrialSession', '--generate' => true]);
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'Schedule', '--generate' => true]);
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'Project', '--generate' => true]);
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'Evaluation', '--generate' => true]);
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'Certificate', '--generate' => true]);
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'Competition', '--generate' => true]);
    return "Filament Resources Generated Successfully!";
});

Route::get('/run-migrations-manual', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    return "Migrations Run Successfully!";
});

Route::get('/make-testimonial-resource-manual', function () {
    \Illuminate\Support\Facades\Artisan::call('make:filament-resource', ['name' => 'Testimonial']);
    return "Testimonial Resource Generated Successfully!";
});

Route::get('/admin/students/{student}/report', function (\App\Models\User $student) {
    // Only allow admin and teacher type users to view reports
    if (!in_array(auth()->user()?->type, ['admin', 'teacher'])) {
        abort(403);
    }
    if ($student->type !== 'student') {
        abort(404);
    }
    
    $student->load([
        'enrollments.group.level.course',
        'attendances.classSession.group',
        'evaluations.course',
        'evaluations.teacher',
        'certificates.course',
        'payments.course',
        'payments.group',
        'payments.installments'
    ]);
    
    return view('student_report', compact('student'));
})->name('student.report')->middleware(['auth']);

Route::get('/certificate/{serial}', function ($serial) {
    $certificate = \App\Models\Certificate::where('serial_number', $serial)->first();
    
    if (!$certificate) {
        abort(404, 'الشهادة المطلوبة غير موجودة.');
    }
    
    $certificate->load(['student', 'course']);
    return view('certificate_verify', compact('certificate'));
});

Route::get('/run-seed-manual', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'DemoSeeder']);
    return "Seeder Run Successfully!";
});

Route::post('/book-trial', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'student_name' => 'required|string|max:255',
        'age' => 'required|integer|min:3|max:18',
        'parent_phone' => 'required|string|max:20',
        'session_date' => 'required|date',
        'notes' => 'nullable|string'
    ]);
    
    $trial = \App\Models\TrialSession::create([
        'student_name' => $request->student_name,
        'age' => $request->age,
        'parent_phone' => $request->parent_phone,
        'session_date' => $request->session_date,
        'notes' => $request->notes,
        'status' => 'pending'
    ]);
    
    // Redirect to WhatsApp with prefilled message
    $whatsappPhone = \App\Models\AcademyInfo::first()?->formatted_whatsapp_phone ?? '201012345678';
    $message = "مرحباً، لقد قمت بحجز جلسة تجريبية لطفلي في الأكاديمية:\n"
             . "- اسم الطفل: {$trial->student_name}\n"
             . "- العمر: {$trial->age} سنوات\n"
             . "- هاتف ولي الأمر: {$trial->parent_phone}\n"
             . "- تاريخ الجلسة المفضل: {$trial->session_date}";
             
    $whatsappUrl = "https://wa.me/{$whatsappPhone}?text=" . urlencode($message);
    
    return redirect($whatsappUrl);
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});
