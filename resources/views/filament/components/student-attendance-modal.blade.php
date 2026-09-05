<div class="aplus-attendance-modal">
    @php
        $total = $student->total_sessions ?: 24;
        $present = $student->present_sessions_count;
        $late = $student->late_sessions_count;
        $attended = $present + $late;
        $absent = $student->absent_sessions_count;
        $remaining = max(0, $total - $attended);
        $percentage = $student->attendance_percentage;
        $attendances = $student->attendances->sortByDesc('created_at');
    @endphp

    <style>
        .aplus-attendance-modal {
            font-family: inherit;
            direction: rtl;
            text-align: right;
            color: #f1f5f9;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            padding: 0.25rem;
        }

        /* Light mode overrides */
        :not(.dark) .aplus-attendance-modal {
            color: #0f172a;
        }

        /* Header Card */
        .aam-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(59, 130, 246, 0.05));
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 1.25rem;
            backdrop-filter: blur(8px);
        }
        :not(.dark) .aam-header {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-color: #bae6fd;
        }

        .aam-student-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .aam-avatar {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #0284c7, #2563eb);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 900;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
            flex-shrink: 0;
        }

        .aam-name {
            font-size: 1.25rem;
            font-weight: 900;
            margin: 0 0 0.25rem 0;
            line-height: 1.2;
            color: #ffffff;
        }
        :not(.dark) .aam-name {
            color: #0f172a;
        }

        .aam-meta {
            font-size: 0.85rem;
            color: #94a3b8;
            margin: 0;
        }
        :not(.dark) .aam-meta {
            color: #64748b;
        }

        .aam-phone {
            direction: ltr;
            display: inline-block;
            font-family: monospace;
            font-weight: 600;
        }

        /* Status Pills */
        .aam-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }
        .aam-badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }
        :not(.dark) .aam-badge-success {
            background: #ecfdf5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .aam-badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }
        :not(.dark) .aam-badge-warning {
            background: #fffbeb;
            color: #92400e;
            border-color: #fde68a;
        }

        .aam-badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }
        :not(.dark) .aam-badge-danger {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Progress Card */
        .aam-progress-box {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        :not(.dark) .aam-progress-box {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .aam-progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .aam-progress-pct {
            color: #38bdf8;
            font-weight: 900;
            font-size: 1.05rem;
        }

        .aam-track {
            width: 100%;
            height: 1.1rem;
            background: rgba(15, 23, 42, 0.7);
            border-radius: 9999px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }
        :not(.dark) .aam-track {
            background: #e2e8f0;
            border-color: #cbd5e1;
        }

        .aam-bar {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .aam-bar-blue {
            background: linear-gradient(90deg, #0284c7, #10b981);
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);
        }
        .aam-bar-warning {
            background: linear-gradient(90deg, #d97706, #f59e0b);
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.4);
        }
        .aam-bar-complete {
            background: linear-gradient(90deg, #e11d48, #f43f5e);
            box-shadow: 0 0 12px rgba(225, 29, 72, 0.4);
        }

        .aam-progress-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 600;
        }

        /* KPI Cards Grid */
        .aam-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.85rem;
        }
        @media (max-width: 640px) {
            .aam-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .aam-card {
            padding: 1rem 0.85rem;
            border-radius: 1.15rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .aam-card:hover {
            transform: translateY(-2px);
        }

        .aam-card-blue {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(59, 130, 246, 0.06));
            border: 1px solid rgba(56, 189, 248, 0.25);
        }
        :not(.dark) .aam-card-blue {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-color: #bae6fd;
        }

        .aam-card-green {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(20, 184, 166, 0.06));
            border: 1px solid rgba(52, 211, 153, 0.25);
        }
        :not(.dark) .aam-card-green {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-color: #a7f3d0;
        }

        .aam-card-amber {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(217, 119, 6, 0.06));
            border: 1px solid rgba(251, 191, 36, 0.25);
        }
        :not(.dark) .aam-card-amber {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border-color: #fde68a;
        }

        .aam-card-rose {
            background: linear-gradient(135deg, rgba(244, 63, 94, 0.12), rgba(225, 29, 72, 0.06));
            border: 1px solid rgba(251, 113, 133, 0.25);
        }
        :not(.dark) .aam-card-rose {
            background: linear-gradient(135deg, #fff1f2, #ffe4e6);
            border-color: #fecdd3;
        }

        .aam-card-icon {
            font-size: 1.6rem;
            line-height: 1;
            margin-bottom: 0.15rem;
        }

        .aam-card-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
        }
        :not(.dark) .aam-card-title {
            color: #64748b;
        }

        .aam-card-num {
            font-size: 1.75rem;
            font-weight: 900;
            line-height: 1.1;
        }
        .aam-card-blue .aam-card-num { color: #38bdf8; }
        :not(.dark) .aam-card-blue .aam-card-num { color: #0284c7; }

        .aam-card-green .aam-card-num { color: #34d399; }
        :not(.dark) .aam-card-green .aam-card-num { color: #059669; }

        .aam-card-amber .aam-card-num { color: #fbbf24; }
        :not(.dark) .aam-card-amber .aam-card-num { color: #d97706; }

        .aam-card-rose .aam-card-num { color: #fb7185; }
        :not(.dark) .aam-card-rose .aam-card-num { color: #e11d48; }

        .aam-card-sub {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
        }
        :not(.dark) .aam-card-sub {
            color: #475569;
        }

        .aam-finance-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.85rem 1.25rem;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
        }
        :not(.dark) .aam-finance-bar {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .aam-finance-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .aam-finance-icon {
            font-size: 1.35rem;
        }

        .aam-finance-title {
            font-size: 0.85rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-left: 0.35rem;
        }
        :not(.dark) .aam-finance-title {
            color: #0f172a;
        }

        .aam-finance-details {
            font-size: 0.82rem;
            color: #94a3b8;
        }
        :not(.dark) .aam-finance-details {
            color: #475569;
        }

        /* History Table Container */
        .aam-table-container {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        :not(.dark) .aam-table-container {
            background: #ffffff;
            border-color: #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .aam-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            background: rgba(15, 23, 42, 0.4);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        :not(.dark) .aam-table-header {
            background: #f8fafc;
            border-bottom-color: #e2e8f0;
        }

        .aam-table-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }
        :not(.dark) .aam-table-title {
            color: #0f172a;
        }

        .aam-print-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.4rem 0.85rem;
            border-radius: 0.75rem;
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.35);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .aam-print-btn:hover {
            background: rgba(56, 189, 248, 0.25);
            color: #ffffff;
            transform: translateY(-1px);
        }
        :not(.dark) .aam-print-btn {
            background: #e0f2fe;
            color: #0369a1;
            border-color: #7dd3fc;
        }

        .aam-scroll-wrap {
            max-height: 18rem;
            overflow-y: auto;
        }

        .aam-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.82rem;
            text-align: right;
        }

        .aam-table th {
            padding: 0.75rem 1rem;
            font-weight: 800;
            font-size: 0.75rem;
            color: #94a3b8;
            background: rgba(15, 23, 42, 0.6);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        :not(.dark) .aam-table th {
            color: #475569;
            background: #f1f5f9;
            border-bottom-color: #cbd5e1;
        }

        .aam-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
            vertical-align: middle;
        }
        :not(.dark) .aam-table td {
            color: #334155;
            border-bottom-color: #f1f5f9;
        }

        .aam-table tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }
        :not(.dark) .aam-table tr:hover td {
            background: #f8fafc;
        }

        /* Pill tags inside table */
        .aam-pill {
            display: inline-block;
            padding: 0.25rem 0.65rem;
            border-radius: 0.5rem;
            font-size: 0.72rem;
            font-weight: 800;
            white-space: nowrap;
        }
        .aam-pill-present {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        :not(.dark) .aam-pill-present {
            background: #dcfce7;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .aam-pill-late {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        :not(.dark) .aam-pill-late {
            background: #fef3c7;
            color: #b45309;
            border-color: #fde68a;
        }

        .aam-pill-absent {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        :not(.dark) .aam-pill-absent {
            background: #fee2e2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .aam-empty {
            padding: 3rem 1rem;
            text-align: center;
            color: #64748b;
        }
    </style>

    <!-- Student Header Summary -->
    <div class="aam-header">
        <div class="aam-student-info">
            <div class="aam-avatar">
                {{ mb_substr($student->name, 0, 1, 'UTF-8') }}
            </div>
            <div>
                <h3 class="aam-name">{{ $student->name }}</h3>
                <p class="aam-meta">
                    ولي الأمر: <strong style="color: inherit;">{{ $student->parent_name ?? '—' }}</strong> &nbsp;|&nbsp;
                    الهاتف: <span class="aam-phone">{{ $student->parent_phone ?? '—' }}</span>
                </p>
            </div>
        </div>
        <div>
            @if($attended >= $total)
                <span class="aam-badge aam-badge-danger">
                    🎉 أتم الـ {{ $total }} حصة بالكامل
                </span>
            @elseif($attended >= ($total - 4))
                <span class="aam-badge aam-badge-warning">
                    ⚠️ شارف على الانتهاء (باقي {{ $remaining }})
                </span>
            @else
                <span class="aam-badge aam-badge-success">
                    🚀 تدريب مستمر (باقي {{ $remaining }} حصة)
                </span>
            @endif
        </div>
    </div>

    <!-- Progress Bar Section -->
    <div class="aam-progress-box">
        <div class="aam-progress-header">
            <span>🎯 نسبة إنجاز الحصص المقررة: <span class="aam-progress-pct">{{ $percentage }}%</span></span>
            <span style="color: #94a3b8;">
                حضر <strong style="color: #34d399;">{{ $attended }}</strong> من أصل <strong style="color: #38bdf8;">{{ $total }}</strong> حصة
            </span>
        </div>

        <div class="aam-track">
            <div class="aam-bar {{ $attended >= $total ? 'aam-bar-complete' : ($attended >= ($total - 4) ? 'aam-bar-warning' : 'aam-bar-blue') }}"
                 style="width: {{ min(100, $percentage) }}%;">
            </div>
        </div>

        <div class="aam-progress-footer">
            <span>البداية: 0 حصة</span>
            <span style="font-weight: 800; color: #38bdf8;">المتبقي للطالب: {{ $remaining }} حصة</span>
            <span>الهدف: {{ $total }} حصة</span>
        </div>
    </div>

    <!-- 4 KPI Stat Cards -->
    <div class="aam-stats-grid">
        <!-- Target -->
        <div class="aam-card aam-card-blue">
            <div class="aam-card-icon">🎯</div>
            <div class="aam-card-title">الرصيد المقرر</div>
            <div class="aam-card-num">{{ $total }}</div>
            <div class="aam-card-sub">حصة تدريبية</div>
        </div>

        <!-- Attended -->
        <div class="aam-card aam-card-green">
            <div class="aam-card-icon">✅</div>
            <div class="aam-card-title">الحصص المحضورة</div>
            <div class="aam-card-num">{{ $attended }}</div>
            <div class="aam-card-sub">حاضر: {{ $present }} | تأخير: {{ $late }}</div>
        </div>

        <!-- Remaining -->
        <div class="aam-card aam-card-amber">
            <div class="aam-card-icon">⏳</div>
            <div class="aam-card-title">الحصص المتبقية</div>
            <div class="aam-card-num">{{ $remaining }}</div>
            <div class="aam-card-sub">حصة متبقية</div>
        </div>

        <!-- Absent -->
        <div class="aam-card aam-card-rose">
            <div class="aam-card-icon">❌</div>
            <div class="aam-card-title">مرات الغياب</div>
            <div class="aam-card-num">{{ $absent }}</div>
            <div class="aam-card-sub">حصة غياب</div>
        </div>
    </div>

    @php
        $payments = $student->payments;
        $hasPayments = $payments->count() > 0;
        $totalNetRequired = $payments->sum(fn ($p) => max(0, $p->total_amount - $p->discount));
        $totalPaid = $payments->sum('paid_amount');
        $totalRemaining = $payments->sum(fn ($p) => $p->remaining_amount);
    @endphp

    @if($hasPayments)
        <div class="aam-finance-bar">
            <div class="aam-finance-left">
                <span class="aam-finance-icon">💳</span>
                <div>
                    <span class="aam-finance-title">الموقف المالي والاشتراكات:</span>
                    <span class="aam-finance-details">
                        المطلوب: <strong>{{ number_format($totalNetRequired, 2) }} ج.م</strong> &nbsp;|&nbsp;
                        المدفوع: <strong style="color: #34d399;">{{ number_format($totalPaid, 2) }} ج.م</strong> &nbsp;|&nbsp;
                        المتبقي: <strong style="color: {{ $totalRemaining > 0 ? '#fb7185' : '#34d399' }};">{{ number_format($totalRemaining, 2) }} ج.م</strong>
                    </span>
                </div>
            </div>
            <div>
                @if($totalRemaining <= 0)
                    <span class="aam-pill aam-pill-present">✔ مسدد بالكامل</span>
                @elseif($totalPaid > 0)
                    <span class="aam-pill aam-pill-late">⏳ سداد جزئي (متبقي {{ number_format($totalRemaining, 0) }} ج.م)</span>
                @else
                    <span class="aam-pill aam-pill-absent">❌ مستحق بالكامل</span>
                @endif
            </div>
        </div>
    @endif

    <!-- Attendance History Table -->
    <div class="aam-table-container">
        <div class="aam-table-header">
            <h4 class="aam-table-title">
                <span>📋</span> سجل الحصص المحضورة ({{ $attendances->count() }} حصة مسجلة)
            </h4>
            <a href="{{ route('student.report', $student) }}" target="_blank" class="aam-print-btn">
                🖨️ طباعة التقرير الشامل
            </a>
        </div>

        <div class="aam-scroll-wrap">
            <table class="aam-table">
                <thead>
                    <tr>
                        <th style="width: 3rem;">#</th>
                        <th>تاريخ الحصة</th>
                        <th>المجموعة</th>
                        <th>موضوع الحصة</th>
                        <th>الحالة</th>
                        <th>ملاحظات المعلم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $index => $item)
                        <tr>
                            <td style="font-family: monospace; opacity: 0.6;">{{ $attendances->count() - $index }}</td>
                            <td style="font-weight: 700; white-space: nowrap;">
                                {{ $item->classSession?->session_date ? $item->classSession->session_date->format('Y-m-d') : ($item->created_at ? $item->created_at->format('Y-m-d') : '—') }}
                            </td>
                            <td style="white-space: nowrap; font-weight: 600;">
                                {{ $item->group?->name ?? $item->classSession?->group?->name ?? '—' }}
                            </td>
                            <td>
                                {{ $item->classSession?->topic ?? '—' }}
                            </td>
                            <td>
                                @if($item->status === 'present')
                                    <span class="aam-pill aam-pill-present">✔ حاضر</span>
                                @elseif($item->status === 'late')
                                    <span class="aam-pill aam-pill-late">⏱️ متأخر</span>
                                @elseif($item->status === 'absent')
                                    <span class="aam-pill aam-pill-absent">❌ غائب</span>
                                @else
                                    <span class="aam-pill">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td style="font-size: 0.75rem; color: #94a3b8; max-width: 14rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $item->notes ?: '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="aam-empty">
                                <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">📭</span>
                                لم يتم تسجيل أي حصص حضور أو غياب لهذا الطالب حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
