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

        <!-- Attendance Stats & Performance Overview (24 Sessions Tracking) -->
        @php
            $totalTargetSessions = $student->total_sessions ?: 24;
            $presentCount = $student->attendances->where('status', 'present')->count();
            $lateCount = $student->attendances->where('status', 'late')->count();
            $attendedCount = $presentCount + $lateCount;
            $absentCount = $student->attendances->where('status', 'absent')->count();
            $remainingSessions = max(0, $totalTargetSessions - $attendedCount);
            $completionRate = $totalTargetSessions > 0 ? min(100, round(($attendedCount / $totalTargetSessions) * 100)) : 0;
            
            $averageScore = $student->evaluations->count() > 0 ? round($student->evaluations->avg('score')) : null;
        @endphp

        <!-- 24-Session Progress Bar Banner -->
        <div class="bg-gradient-to-r from-sky-50 to-blue-50 border border-sky-200 rounded-3xl p-6 mb-8 text-right">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mb-3">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🎯</span>
                    <div>
                        <h4 class="font-black text-slate-900 text-lg">خطة الـ {{ $totalTargetSessions }} حصة المقررة</h4>
                        <p class="text-xs text-slate-500 font-bold">متابعة إنجاز وحضور الطفل لكامل المقرر</p>
                    </div>
                </div>
                <div class="text-left">
                    <span class="text-sm font-bold text-slate-600">نسبة الإنجاز: </span>
                    <span class="text-xl font-black text-blue-700">{{ $completionRate }}%</span>
                </div>
            </div>
            
            <!-- Progress track -->
            <div class="w-full bg-slate-200 rounded-full h-5 p-1 border border-slate-300/80 overflow-hidden shadow-inner">
                <div class="h-full rounded-full transition-all duration-700 bg-gradient-to-r {{ $attendedCount >= $totalTargetSessions ? 'from-red-500 to-rose-600' : ($attendedCount >= ($totalTargetSessions - 4) ? 'from-amber-500 to-orange-500' : 'from-blue-500 to-emerald-500') }}"
                     style="width: {{ $completionRate }}%;">
                </div>
            </div>
            
            <div class="flex justify-between items-center text-xs font-extrabold text-slate-500 mt-2">
                <span>0 حصة (البداية)</span>
                <span class="text-blue-900 bg-blue-100 px-3 py-1 rounded-full">حضر {{ $attendedCount }} من {{ $totalTargetSessions }} حصة</span>
                <span>{{ $totalTargetSessions }} حصة (الهدف)</span>
            </div>
        </div>

        <!-- 4 KPI Stat Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <!-- Stat 1: Target -->
            <div class="bg-blue-50 p-4 rounded-2xl text-center border border-blue-200">
                <span class="block text-2xl mb-1">🎯</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">الرصيد المقرر</span>
                <span class="text-2xl font-black text-blue-900">{{ $totalTargetSessions }}</span>
                <span class="block text-[11px] text-blue-600 font-bold mt-1">حصة تدريبية</span>
            </div>
            <!-- Stat 2: Attended -->
            <div class="bg-green-50 p-4 rounded-2xl text-center border border-green-200">
                <span class="block text-2xl mb-1">✅</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">الحصص المحضورة</span>
                <span class="text-2xl font-black text-green-900">{{ $attendedCount }}</span>
                <span class="block text-[11px] text-green-700 font-bold mt-1">حاضر: {{ $presentCount }} | تأخير: {{ $lateCount }}</span>
            </div>
            <!-- Stat 3: Remaining -->
            <div class="bg-amber-50 p-4 rounded-2xl text-center border border-amber-200">
                <span class="block text-2xl mb-1">⏳</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">الحصص المتبقية</span>
                <span class="text-2xl font-black text-amber-900">{{ $remainingSessions }}</span>
                <span class="block text-[11px] text-amber-700 font-bold mt-1">حصة متبقية</span>
            </div>
            <!-- Stat 4: Absent -->
            <div class="bg-rose-50 p-4 rounded-2xl text-center border border-rose-200">
                <span class="block text-2xl mb-1">❌</span>
                <span class="block text-slate-500 font-bold text-xs mb-1">مرات الغياب</span>
                <span class="text-2xl font-black text-rose-900">{{ $absentCount }}</span>
                <span class="block text-[11px] text-rose-700 font-bold mt-1">حصة غياب</span>
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

        <!-- Financial & Tuition Report (تقرير المصروفات والمدفوعات) -->
        <div class="mb-8 text-right">
            @php
                $payments = $student->payments;
                $totalNetRequired = $payments->sum(fn ($p) => max(0, $p->total_amount - $p->discount));
                $totalPaid = $payments->sum('paid_amount');
                $totalRemaining = $payments->sum(fn ($p) => $p->remaining_amount);
                $hasPayments = $payments->count() > 0;
                $isAllPaid = $hasPayments && $totalRemaining <= 0;
                $isPartiallyPaid = $hasPayments && $totalPaid > 0 && $totalRemaining > 0;
                $isUnpaid = $hasPayments && $totalPaid <= 0 && $totalRemaining > 0;
            @endphp

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                <h3 class="text-xl font-black text-slate-900 border-r-4 border-emerald-500 pr-3 flex items-center gap-2">
                    <span>💳</span> تقرير المصروفات والمدفوعات المالية
                </h3>
                @if($hasPayments)
                    <div>
                        @if($isAllPaid)
                            <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 font-black text-xs px-4 py-1.5 rounded-full inline-flex items-center gap-1 shadow-sm">
                                ✅ تم السداد بالكامل (لا توجد متبقيات)
                            </span>
                        @elseif($isPartiallyPaid)
                            <span class="bg-amber-100 text-amber-800 border border-amber-300 font-black text-xs px-4 py-1.5 rounded-full inline-flex items-center gap-1 shadow-sm">
                                ⏳ سداد جزئي (متبقي: {{ number_format($totalRemaining, 2) }} ج.م)
                            </span>
                        @else
                            <span class="bg-rose-100 text-rose-800 border border-rose-300 font-black text-xs px-4 py-1.5 rounded-full inline-flex items-center gap-1 shadow-sm">
                                ❌ لم يتم السداد (مستحق: {{ number_format($totalRemaining, 2) }} ج.م)
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            @if($hasPayments)
                <!-- 3 Quick Financial KPI Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <!-- Total Required -->
                    <div class="bg-gradient-to-br from-blue-50 to-sky-50 p-4 rounded-2xl border border-blue-200 text-center">
                        <span class="block text-slate-500 font-bold text-xs mb-1">إجمالي المطلوب (بعد الخصم)</span>
                        <span class="text-2xl font-black text-blue-900">{{ number_format($totalNetRequired, 2) }}</span>
                        <span class="text-xs text-blue-700 font-bold block mt-0.5">جنيه مصري</span>
                    </div>

                    <!-- Paid Amount -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-4 rounded-2xl border border-emerald-200 text-center">
                        <span class="block text-slate-500 font-bold text-xs mb-1">المبلغ المدفوع (المحصل)</span>
                        <span class="text-2xl font-black text-emerald-800">{{ number_format($totalPaid, 2) }}</span>
                        <span class="text-xs text-emerald-700 font-bold block mt-0.5">جنيه مصري</span>
                    </div>

                    <!-- Remaining Amount -->
                    <div class="bg-gradient-to-br from-{{ $totalRemaining > 0 ? 'rose' : 'emerald' }}-50 to-{{ $totalRemaining > 0 ? 'red' : 'teal' }}-50 p-4 rounded-2xl border border-{{ $totalRemaining > 0 ? 'rose' : 'emerald' }}-200 text-center">
                        <span class="block text-slate-500 font-bold text-xs mb-1">المبلغ المتبقي المستحق</span>
                        <span class="text-2xl font-black text-{{ $totalRemaining > 0 ? 'rose-700' : 'emerald-700' }}">
                            {{ number_format($totalRemaining, 2) }}
                        </span>
                        <span class="text-xs text-{{ $totalRemaining > 0 ? 'rose' : 'emerald' }}-600 font-bold block mt-0.5">
                            {{ $totalRemaining > 0 ? 'جنيه مصري مستحق' : 'تم السداد بالكامل ✔' }}
                        </span>
                    </div>
                </div>

                <!-- Detailed Payments Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-slate-800 border border-slate-200 rounded-2xl overflow-hidden">
                        <thead class="bg-slate-50 text-slate-700 text-xs font-bold">
                            <tr>
                                <th class="p-3 text-right">الكورس / الاشتراك</th>
                                <th class="p-3 text-right">خطة الدفع</th>
                                <th class="p-3 text-center">إجمالي الرسوم</th>
                                <th class="p-3 text-center">الخصم</th>
                                <th class="p-3 text-center">المدفوع</th>
                                <th class="p-3 text-center">المتبقي</th>
                                <th class="p-3 text-center">حالة السداد</th>
                                <th class="p-3 text-center">الاستحقاق</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($payments as $payment)
                                @php
                                    $rem = $payment->remaining_amount;
                                    $planLabel = match($payment->payment_plan) {
                                        'monthly' => 'شهري',
                                        'quarterly' => 'ربع سنوي (3 شهور)',
                                        'full' => 'دفعة كاملة',
                                        default => $payment->payment_plan ?: '—'
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="p-3">
                                        <span class="font-extrabold text-slate-900 block">{{ $payment->course?->title ?? 'اشتراك أكاديمي' }}</span>
                                        @if($payment->group)
                                            <span class="text-xs text-slate-500 font-medium">المجموعة: {{ $payment->group->name }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-xs font-semibold text-slate-600">
                                        <span class="bg-slate-100 px-2 py-1 rounded-md">{{ $planLabel }}</span>
                                    </td>
                                    <td class="p-3 text-center font-bold text-slate-900 dir-ltr">
                                        {{ number_format($payment->total_amount, 2) }} ج.م
                                    </td>
                                    <td class="p-3 text-center text-xs text-slate-500 dir-ltr">
                                        {{ $payment->discount > 0 ? number_format($payment->discount, 2) . ' ج.م' : '—' }}
                                    </td>
                                    <td class="p-3 text-center font-bold text-emerald-700 dir-ltr">
                                        {{ number_format($payment->paid_amount, 2) }} ج.م
                                    </td>
                                    <td class="p-3 text-center font-bold {{ $rem > 0 ? 'text-rose-600' : 'text-slate-400' }} dir-ltr">
                                        {{ number_format($rem, 2) }} ج.م
                                    </td>
                                    <td class="p-3 text-center">
                                        @if($rem <= 0 || $payment->status === 'paid')
                                            <span class="px-2.5 py-1 text-xs font-black rounded-full bg-green-100 text-green-800">
                                                ✔ مسدد بالكامل
                                            </span>
                                        @elseif($payment->paid_amount > 0)
                                            <span class="px-2.5 py-1 text-xs font-black rounded-full bg-amber-100 text-amber-800">
                                                ⏳ سداد جزئي
                                            </span>
                                        @elseif($payment->status === 'overdue' || $payment->is_overdue)
                                            <span class="px-2.5 py-1 text-xs font-black rounded-full bg-red-100 text-red-800">
                                                ⚠️ متأخر
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-black rounded-full bg-rose-100 text-rose-800">
                                                ❌ مستحق
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center text-xs text-slate-500 whitespace-nowrap">
                                        @if($rem <= 0)
                                            <span class="text-green-600 font-bold">مكتمل</span>
                                        @elseif($payment->next_due_date)
                                            <span class="{{ $payment->is_overdue ? 'text-red-600 font-bold' : '' }}">
                                                {{ $payment->next_due_date->format('Y-m-d') }}
                                            </span>
                                        @else
                                            <span>غير محدد</span>
                                        @endif
                                    </td>
                                </tr>

                                @if($payment->installments->count() > 0)
                                    <tr class="bg-slate-50/50">
                                        <td colspan="8" class="p-3 pr-6">
                                            <div class="text-xs text-slate-600 space-y-1">
                                                <span class="font-bold text-slate-700 block mb-1">📅 تفاصيل الأقساط المسجلة:</span>
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                                    @foreach($payment->installments as $idx => $inst)
                                                        <div class="p-2 rounded-lg bg-white border border-slate-200 flex justify-between items-center text-[11px]">
                                                            <span>قسط #{{ $idx + 1 }}: <strong>{{ number_format($inst->amount, 2) }} ج.م</strong></span>
                                                            <span class="font-medium">
                                                                {{ $inst->due_date ? $inst->due_date->format('Y-m-d') : '—' }}
                                                            </span>
                                                            <span class="px-1.5 py-0.5 rounded font-bold {{ $inst->status === 'paid' ? 'bg-green-100 text-green-800' : ($inst->is_overdue ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                                {{ match($inst->status) { 'paid' => 'مدفوع ✔', 'overdue' => 'متأخر ⚠️', default => 'مستحق' } }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-slate-500 border border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                    <span class="text-2xl block mb-1">💳</span>
                    لا توجد أي اشتراكات أو مدفوعات مسجلة للطالب حالياً.
                </div>
            @endif
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
