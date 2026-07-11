<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير الطالب: {{ $student->name }} | A+ Academy</title>
    <!-- Outfit & Tajawal Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f0f9ff;
        }
        @media print {
            body {
                background-color: #ffffff;
            }
            .no-print {
                display: none !important;
            }
            .print-card {
                border: 1px solid #e2e8f0 !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="p-6 md:p-12 text-slate-800">

    <!-- Action Buttons (No Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="/admin/students" class="bg-slate-600 hover:bg-slate-700 text-white font-bold px-6 py-3 rounded-xl shadow transition-all flex items-center gap-2">
            ← العودة للوحة التحكم
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-8 py-3 rounded-xl shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
            🖨️ طباعة التقرير
        </button>
    </div>

    <!-- Printable Report Container -->
    <div class="max-w-4xl mx-auto bg-white rounded-[2rem] shadow-xl border border-sky-100 p-8 md:p-12 relative overflow-hidden print-card">
        
        <!-- Kids theme decorations (hides in print if needed, but looks nice anyway) -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-yellow-50 rounded-full blur-3xl opacity-60"></div>

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center border-b-4 border-dashed border-sky-100 pb-8 mb-8 gap-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16" onerror="this.src='https://aplusacademy.courses/images/logo.png'">
                <div class="text-right">
                    <h1 class="text-3xl font-black text-blue-600">A+ Academy</h1>
                    <p class="text-slate-500 font-bold text-sm">أكاديمية تعليم البرمجة والذكاء الاصطناعي للأطفال</p>
                </div>
            </div>
            <div class="text-center md:text-left bg-sky-50 px-6 py-3 rounded-2xl border border-sky-200">
                <span class="block text-slate-500 font-bold text-xs">تاريخ استخراج التقرير</span>
                <span class="text-blue-900 font-bold text-base">{{ date('Y-m-d') }}</span>
            </div>
        </div>

        <!-- Student Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-sky-50/50 p-6 rounded-3xl border border-sky-100 mb-8 text-right">
            <div>
                <p class="text-sm text-slate-500 font-bold mb-1">اسم الطالب:</p>
                <p class="text-xl font-black text-slate-900">{{ $student->name }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-bold mb-1">عمر الطالب:</p>
                <p class="text-lg font-bold text-slate-950">{{ $student->age ?? 'غير مسجل' }} سنة</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-bold mb-1">اسم ولي الأمر:</p>
                <p class="text-lg font-bold text-slate-950">{{ $student->parent_name ?? 'غير مسجل' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-bold mb-1">هاتف ولي الأمر:</p>
                <p class="text-lg font-bold text-slate-950 dir-ltr">{{ $student->parent_phone ?? 'غير مسجل' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-bold mb-1">المدرسة:</p>
                <p class="text-lg font-bold text-slate-950">{{ $student->school ?? 'غير مسجل' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-bold mb-1">هاتف الطالب:</p>
                <p class="text-lg font-bold text-slate-950 dir-ltr">{{ $student->phone ?? 'غير مسجل' }}</p>
            </div>
        </div>

        <!-- Attendance Stats & Performance Overview -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalSessions = $student->attendances->count();
                $presentCount = $student->attendances->where('status', 'present')->count();
                $lateCount = $student->attendances->where('status', 'late')->count();
                $absentCount = $student->attendances->where('status', 'absent')->count();
                $attendanceRate = $totalSessions > 0 ? round((($presentCount + $lateCount) / $totalSessions) * 100) : 100;
                
                $averageScore = $student->evaluations->count() > 0 ? round($student->evaluations->avg('score')) : null;
            @endphp
            <!-- Stat 1 -->
            <div class="bg-blue-50 p-4 rounded-2xl text-center border border-blue-200">
                <span class="block text-2xl mb-1">📅</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">إجمالي الحصص</span>
                <span class="text-2xl font-black text-blue-900">{{ $totalSessions }}</span>
            </div>
            <!-- Stat 2 -->
            <div class="bg-green-50 p-4 rounded-2xl text-center border border-green-200">
                <span class="block text-2xl mb-1">✅</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">نسبة الحضور</span>
                <span class="text-2xl font-black text-green-900">{{ $attendanceRate }}%</span>
            </div>
            <!-- Stat 3 -->
            <div class="bg-amber-50 p-4 rounded-2xl text-center border border-amber-200">
                <span class="block text-2xl mb-1">📊</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">متوسط التقييم</span>
                <span class="text-2xl font-black text-amber-900">{{ $averageScore ? $averageScore . ' / 100' : 'لا يوجد' }}</span>
            </div>
            <!-- Stat 4 -->
            <div class="bg-purple-50 p-4 rounded-2xl text-center border border-purple-200">
                <span class="block text-2xl mb-1">🏆</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">الشهادات</span>
                <span class="text-2xl font-black text-purple-900">{{ $student->certificates->count() }}</span>
            </div>
        </div>

        <!-- Detailed Classes / Groups Enrolled -->
        <div class="mb-8 text-right">
            <h3 class="text-xl font-black text-slate-900 border-r-4 border-blue-500 pr-3 mb-4">المجموعات والكورسات المشترك بها</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-slate-800 border border-slate-200 rounded-xl overflow-hidden">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-3 text-right font-bold text-slate-700">الكورس</th>
                            <th class="p-3 text-right font-bold text-slate-700">المستوى</th>
                            <th class="p-3 text-right font-bold text-slate-700">المجموعة</th>
                            <th class="p-3 text-right font-bold text-slate-700">المواعيد</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($student->enrollments as $enrollment)
                        <tr>
                            <td class="p-3 font-bold text-slate-900">{{ $enrollment->group?->level?->course?->title ?? 'كورس البرمجة' }}</td>
                            <td class="p-3">{{ $enrollment->group?->level?->name ?? 'المستوى الأول' }}</td>
                            <td class="p-3 font-semibold text-blue-700">{{ $enrollment->group?->name ?? 'غير محدد' }}</td>
                            <td class="p-3">{{ $enrollment->group?->schedule ?? 'غير محدد' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-slate-500">الطفل غير مسجل في أي مجموعات حالياً.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Academic Evaluations -->
        <div class="mb-8 text-right">
            <h3 class="text-xl font-black text-slate-900 border-r-4 border-amber-500 pr-3 mb-4">تقييمات الأداء الأكاديمي والواجبات</h3>
            <div class="space-y-4">
                @forelse($student->evaluations as $eval)
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-150 relative">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="bg-amber-100 text-amber-800 font-extrabold text-sm px-3 py-1 rounded-full">{{ $eval->score }} / 100</span>
                        </div>
                        <div class="text-right">
                            <h4 class="font-bold text-slate-900">{{ $eval->course?->title ?? 'تقييم كورس' }}</h4>
                            <span class="text-xs text-slate-500">بواسطة المهندس: {{ $eval->teacher?->name ?? 'مدرب الأكاديمية' }} | {{ $eval->evaluation_date }}</span>
                        </div>
                    </div>
                    <p class="text-slate-700 text-sm leading-relaxed mt-2 border-t border-slate-200/50 pt-2">
                        <strong>ملاحظات المهندس:</strong> {{ $eval->feedback ?? 'أداء ممتاز ومشارك متفاعل خلال الحصة.' }}
                    </p>
                </div>
                @empty
                <div class="p-4 text-center text-slate-500 border border-dashed border-slate-200 rounded-2xl">لا توجد تقييمات مسجلة للطفل بعد.</div>
                @endforelse
            </div>
        </div>

        <!-- Attendance Logs -->
        <div class="mb-8 text-right">
            <h3 class="text-xl font-black text-slate-900 border-r-4 border-green-500 pr-3 mb-4">سجل الحضور والغياب الأخير</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-slate-800 border border-slate-200 rounded-xl overflow-hidden">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-3 text-right font-bold text-slate-700">تاريخ الحصة</th>
                            <th class="p-3 text-right font-bold text-slate-700">الموضوع</th>
                            <th class="p-3 text-right font-bold text-slate-700">الحالة</th>
                            <th class="p-3 text-right font-bold text-slate-700">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($student->attendances->take(10) as $attendance)
                        <tr>
                            <td class="p-3 font-semibold">{{ $attendance->classSession?->session_date ?? 'غير محدد' }}</td>
                            <td class="p-3">{{ $attendance->classSession?->topic ?? 'غير محدد' }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 rounded-full font-bold text-xs 
                                    {{ $attendance->status == 'present' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $attendance->status == 'absent' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $attendance->status == 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ match($attendance->status) { 'present' => 'حاضر', 'absent' => 'غائب', 'late' => 'متأخر', default => $attendance->status } }}
                                </span>
                            </td>
                            <td class="p-3 text-xs text-slate-600">{{ $attendance->notes ?? 'لا يوجد ملاحظات' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-slate-500">لا يوجد سجل حضور وغياب مسجل.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Certificates Section -->
        <div class="mb-8 text-right">
            <h3 class="text-xl font-black text-slate-900 border-r-4 border-purple-500 pr-3 mb-4">🏆 الشهادات المكتسبة</h3>
            @if($student->certificates->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($student->certificates as $cert)
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-2xl p-5 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-20 h-20 bg-purple-100 rounded-full blur-2xl opacity-60"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between mb-3">
                            <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                {{ $cert->issue_date ?? 'تاريخ غير محدد' }}
                            </span>
                            <div class="text-3xl">🎓</div>
                        </div>
                        <h4 class="font-black text-slate-900 text-lg mb-1">{{ $cert->course?->title ?? 'كورس البرمجة' }}</h4>
                        <p class="text-sm text-slate-600 mb-3">{{ $cert->notes ?? 'شهادة إتمام الكورس بنجاح' }}</p>
                        @if($cert->serial_number)
                        <div class="bg-white/60 rounded-xl px-3 py-2 border border-purple-100 flex items-center justify-between gap-2">
                            <span class="text-xs text-purple-700 font-black dir-ltr">{{ $cert->serial_number }}</span>
                            <a href="/certificate/{{ $cert->serial_number }}" target="_blank"
                               class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-3 py-1 rounded-lg transition-all flex items-center gap-1">
                                🎖️ عرض الشهادة
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-6 text-center text-slate-500 border border-dashed border-purple-200 rounded-2xl bg-purple-50/30">
                <span class="text-3xl block mb-2">🎓</span>
                لا توجد شهادات مسجلة للطفل بعد.
            </div>
            @endif
        </div>

        <div class="border-t-4 border-dashed border-sky-100 pt-6 mt-10 text-center">
            <p class="text-sm font-bold text-blue-600">نشكركم على ثقتكم في أكاديمية A+ لمعرفة وإرشاد بطلكم الصغير 🚀</p>
            <p class="text-xs text-slate-400 mt-1">A+ Academy - Build Your Future</p>
        </div>

    </div>

</body>
</html>
