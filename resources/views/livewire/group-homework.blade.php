<div style="padding: 1.5rem; color: #f3f4f6; height: 100%; overflow-y: auto;">

    <!-- Success Message Alert -->
    @if ($successMessage)
        <div style="background-color: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #6ee7b7; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: bold;">
                <span>✅</span>
                <span>{{ $successMessage }}</span>
            </div>
            <button type="button" wire:click="$set('successMessage', null)" style="color: #6ee7b7; cursor: pointer; background: none; border: none; font-size: 1.25rem;">✕</button>
        </div>
    @endif

    @if ($isStudent)
        <!-- ================= STUDENT VIEW ================= -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            
            <!-- Upload Box -->
            <div style="background: rgba(31, 41, 55, 0.7); border: 1px solid #374151; border-radius: 1.5rem; padding: 1.5rem; backdrop-filter: blur(10px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem; border-bottom: 1px solid #374151; padding-bottom: 0.75rem;">
                    <span style="font-size: 1.75rem;">🚀</span>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: #60a5fa; margin: 0;">تسليم واجب أو مشروع جديد</h3>
                        <p style="font-size: 0.85rem; color: #9ca3af; margin: 0;">ارفع مشروعك أو ملف الواجب ليشاهده المهندس ويقيمه لك 🌟</p>
                    </div>
                </div>

                <form wire:submit.prevent="submitHomework">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        
                        <!-- Title -->
                        <div>
                            <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">عنوان الواجب أو اسم المشروع <span style="color: #ef4444;">*</span></label>
                            <input type="text" wire:model="title" placeholder="مثال: مشروع المتاهة في سكراتش" style="width: 100%; background: #111827; border: 1px solid #4b5563; border-radius: 0.75rem; padding: 0.75rem 1rem; color: white; font-size: 0.95rem; outline: none;" required />
                            @error('title') <span style="color: #f87171; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                            <!-- File Upload -->
                            <div>
                                <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">رفع ملف الواجب (سكراتش .sb3، كود، صورة، PDF، مضغوط)</label>
                                <input type="file" wire:model="file" style="width: 100%; background: #111827; border: 1px dashed #6b7280; border-radius: 0.75rem; padding: 0.6rem 1rem; color: #9ca3af; font-size: 0.85rem; cursor: pointer;" />
                                <div wire:loading wire:target="file" style="font-size: 0.8rem; color: #fbbf24; margin-top: 0.25rem;">⏳ جاري رفع الملف، يرجى الانتظار...</div>
                                @error('file') <span style="color: #f87171; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                            </div>

                            <!-- Link URL -->
                            <div>
                                <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">أو رابط المشروع (Scratch, GitHub, Drive)</label>
                                <input type="url" wire:model="link_url" placeholder="https://scratch.mit.edu/projects/..." style="width: 100%; background: #111827; border: 1px solid #4b5563; border-radius: 0.75rem; padding: 0.75rem 1rem; color: white; font-size: 0.95rem; outline: none;" />
                                @error('link_url') <span style="color: #f87171; font-size: 0.8rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Description / Notes -->
                        <div>
                            <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">ملاحظات للمهندس (اختياري)</label>
                            <textarea wire:model="description" rows="2" placeholder="اكتب أي ملاحظة أو رسالة للمهندس بخصوص الواجب..." style="width: 100%; background: #111827; border: 1px solid #4b5563; border-radius: 0.75rem; padding: 0.75rem 1rem; color: white; font-size: 0.95rem; outline: none;"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div style="text-align: left; margin-top: 0.5rem;">
                            <button type="submit" wire:loading.attr="disabled" style="background: linear-gradient(135deg, #2563eb, #7c3aed); color: white; border: none; padding: 0.75rem 2rem; border-radius: 0.75rem; font-size: 1rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); display: inline-flex; align-items: center; gap: 0.5rem;">
                                <span>تسليم الواجب الآن</span>
                                <span>🚀</span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Student Submissions History -->
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: white; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📁</span>
                    <span>واجباتي المسلمة في هذه المجموعة ({{ $submissions->count() }})</span>
                </h3>

                @if ($submissions->isEmpty())
                    <div style="background: #1f2937; border: 1px dashed #374151; border-radius: 1rem; padding: 2.5rem; text-align: center; color: #9ca3af;">
                        <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🎨</span>
                        <p style="font-size: 1rem; font-weight: 700; margin: 0;">لم تقم بتسليم أي واجب بعد في هذه المجموعة.</p>
                        <p style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">استخدم النموذج أعلاه لتسليم أول مشروع لك وبدء التميز!</p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1rem;">
                        @foreach ($submissions as $sub)
                            <div style="background: #1f2937; border: 1px solid #374151; border-radius: 1.25rem; padding: 1.25rem; position: relative;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                    <h4 style="font-size: 1.05rem; font-weight: 800; color: white; margin: 0;">{{ $sub->title }}</h4>
                                    <span style="font-size: 0.75rem; font-weight: 800; padding: 0.25rem 0.65rem; border-radius: 9999px; background-color: {{ $sub->status === 'approved' ? 'rgba(16, 185, 129, 0.2)' : ($sub->status === 'needs_revision' ? 'rgba(245, 158, 11, 0.2)' : 'rgba(59, 130, 246, 0.2)') }}; color: {{ $sub->status === 'approved' ? '#34d399' : ($sub->status === 'needs_revision' ? '#fbbf24' : '#60a5fa') }}; border: 1px solid currentColor;">
                                        {{ $sub->status_label }}
                                    </span>
                                </div>

                                <p style="font-size: 0.75rem; color: #9ca3af; margin-bottom: 0.75rem;">
                                    📅 تم التسليم: {{ $sub->created_at->format('Y-m-d h:i A') }}
                                </p>

                                @if ($sub->description)
                                    <p style="font-size: 0.85rem; color: #d1d5db; background: #111827; padding: 0.5rem 0.75rem; border-radius: 0.5rem; margin-bottom: 0.75rem;">
                                        {{ $sub->description }}
                                    </p>
                                @endif

                                <!-- File / Link Buttons -->
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.75rem;">
                                    @if ($sub->file_path)
                                        <a href="{{ $sub->file_url }}" target="_blank" download style="background: #374151; hover:background: #4b5563; color: white; font-size: 0.8rem; font-weight: 700; padding: 0.4rem 0.75rem; border-radius: 0.5rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                            <span>📥</span>
                                            <span>تحميل الملف المرفق</span>
                                        </a>
                                    @endif

                                    @if ($sub->link_url)
                                        <a href="{{ $sub->link_url }}" target="_blank" style="background: #1e3a8a; color: #93c5fd; font-size: 0.8rem; font-weight: 700; padding: 0.4rem 0.75rem; border-radius: 0.5rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                            <span>🔗</span>
                                            <span>فتح رابط المشروع</span>
                                        </a>
                                    @endif
                                </div>

                                <!-- Teacher Evaluation / Feedback Box -->
                                @if ($sub->evaluated_at || $sub->score !== null || $sub->feedback)
                                    <div style="background: rgba(30, 27, 75, 0.6); border: 1px solid #4338ca; border-radius: 0.75rem; padding: 0.75rem; margin-top: 0.75rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                                            <span style="font-size: 0.8rem; font-weight: 800; color: #a5b4fc;">تقييم المهندس:</span>
                                            @if ($sub->score !== null)
                                                <span style="font-size: 0.9rem; font-weight: 900; color: #fbbf24; background: #312e81; padding: 0.15rem 0.5rem; border-radius: 0.5rem;">
                                                    ⭐ الدرجة: {{ $sub->score }} / 100
                                                </span>
                                            @endif
                                        </div>
                                        @if ($sub->feedback)
                                            <p style="font-size: 0.85rem; color: #e0e7ff; margin: 0; font-style: italic;">
                                                "{{ $sub->feedback }}"
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                @if ($sub->status === 'pending')
                                    <div style="margin-top: 0.75rem; text-align: left;">
                                        <button wire:click="deleteSubmission({{ $sub->id }})" wire:confirm="هل تريد بالتأكيد حذف هذا التسليم؟" style="color: #ef4444; background: none; border: none; font-size: 0.75rem; cursor: pointer; text-decoration: underline;">
                                            حذف التسليم
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    @else
        <!-- ================= TEACHER & ADMIN VIEW ================= -->
        <div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h3 style="font-size: 1.3rem; font-weight: 900; color: white; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <span>📚</span>
                        <span>واجبات ومشاريع طلاب المجموعة ({{ $group->name }})</span>
                    </h3>
                    <p style="font-size: 0.85rem; color: #9ca3af; margin: 0.25rem 0 0 0;">
                        استعراض كافة التسليمات من الطلاب وتحميلها وتقييمها وإعطاء التغذية الراجعة
                    </p>
                </div>

                <!-- Stats summary badges -->
                <div style="display: flex; gap: 0.75rem;">
                    <span style="background: #374151; color: white; padding: 0.4rem 0.85rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700;">
                        إجمالي التسليمات: <strong>{{ $submissions->count() }}</strong>
                    </span>
                    <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid #f59e0b; padding: 0.4rem 0.85rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700;">
                        قيد المراجعة: <strong>{{ $submissions->where('status', 'pending')->count() }}</strong>
                    </span>
                    <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid #10b981; padding: 0.4rem 0.85rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700;">
                        تم التقييم: <strong>{{ $submissions->where('status', 'approved')->count() }}</strong>
                    </span>
                </div>
            </div>

            <!-- Evaluation Inline Modal/Box -->
            @if ($evaluatingId)
                <div style="background: #111827; border: 2px solid #6366f1; border-radius: 1.5rem; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #374151; padding-bottom: 0.5rem;">
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #818cf8; margin: 0;">
                            📝 تقييم واجب الطالب: {{ $submissions->firstWhere('id', $evaluatingId)?->student?->name }}
                        </h4>
                        <button type="button" wire:click="cancelEvaluation" style="color: #9ca3af; background: none; border: none; font-size: 1.25rem; cursor: pointer;">✕</button>
                    </div>

                    <form wire:submit.prevent="saveEvaluation">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">الدرجة (من 100)</label>
                                <input type="number" min="0" max="100" wire:model="score" placeholder="مثال: 95" style="width: 100%; background: #1f2937; border: 1px solid #4b5563; border-radius: 0.75rem; padding: 0.65rem 1rem; color: white; font-size: 0.95rem;" required />
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">حالة الواجب</label>
                                <select wire:model="status" style="width: 100%; background: #1f2937; border: 1px solid #4b5563; border-radius: 0.75rem; padding: 0.65rem 1rem; color: white; font-size: 0.95rem;">
                                    <option value="approved">معتمد وممتاز 🌟</option>
                                    <option value="needs_revision">يحتاج تعديل ✏️</option>
                                    <option value="pending">قيد المراجعة ⏳</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #d1d5db; margin-bottom: 0.35rem;">ملاحظات المهندس وتشجيع الطالب</label>
                            <textarea wire:model="feedback" rows="3" placeholder="اكتب تعليقك على المشروع، ملاحظات التحسين، وكلمات تشجيعية للبطل..." style="width: 100%; background: #1f2937; border: 1px solid #4b5563; border-radius: 0.75rem; padding: 0.65rem 1rem; color: white; font-size: 0.95rem;"></textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                            <button type="button" wire:click="cancelEvaluation" style="background: #374151; color: white; border: none; padding: 0.6rem 1.25rem; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 700; cursor: pointer;">إلغاء</button>
                            <button type="submit" style="background: #10b981; color: white; border: none; padding: 0.6rem 1.75rem; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);">حفظ التقييم ✨</button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Submissions Table -->
            @if ($submissions->isEmpty())
                <div style="background: #1f2937; border: 1px dashed #374151; border-radius: 1.5rem; padding: 3rem; text-align: center; color: #9ca3af;">
                    <span style="font-size: 3rem; display: block; margin-bottom: 0.5rem;">📂</span>
                    <p style="font-size: 1.1rem; font-weight: 800; margin: 0; color: white;">لا توجد أي واجبات مسلمة في هذه المجموعة بعد.</p>
                    <p style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">عندما يقوم أي طالب برفع واجبه ستظهر بياناته هنا فوراً للمعاينة والتقييم.</p>
                </div>
            @else
                <div style="overflow-x: auto; background: #1f2937; border: 1px solid #374151; border-radius: 1.25rem;">
                    <table style="width: 100%; text-align: right; border-collapse: collapse; font-size: 0.9rem;">
                        <thead style="background: #111827; color: #9ca3af; border-bottom: 1px solid #374151;">
                            <tr>
                                <th style="padding: 1rem;">الطالب</th>
                                <th style="padding: 1rem;">عنوان الواجب / المشروع</th>
                                <th style="padding: 1rem;">الملف / الرابط</th>
                                <th style="padding: 1rem;">تاريخ التسليم</th>
                                <th style="padding: 1rem;">الحالة والدرجة</th>
                                <th style="padding: 1rem; text-align: center;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody style="divide-y: 1px solid #374151;">
                            @foreach ($submissions as $sub)
                                <tr style="border-bottom: 1px solid #2d3748; transition: background 0.2s;" onmouseover="this.style.background='rgba(55, 65, 81, 0.4)'" onmouseout="this.style.background='transparent'">
                                    <!-- Student -->
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 800; color: white;">{{ $sub->student?->name ?? 'غير محدد' }}</div>
                                        <div style="font-size: 0.75rem; color: #9ca3af;">{{ $sub->student?->phone ?? '' }}</div>
                                    </td>

                                    <!-- Title & Description -->
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 800; color: #93c5fd;">{{ $sub->title }}</div>
                                        @if ($sub->description)
                                            <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 0.2rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $sub->description }}">
                                                {{ $sub->description }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- File / Link -->
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                            @if ($sub->file_path)
                                                <a href="{{ $sub->file_url }}" target="_blank" download style="background: #374151; color: white; padding: 0.35rem 0.65rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                                    <span>📥</span>
                                                    <span>تحميل ({{ $sub->file_name ?? 'ملف' }})</span>
                                                </a>
                                            @endif

                                            @if ($sub->link_url)
                                                <a href="{{ $sub->link_url }}" target="_blank" style="background: #1e3a8a; color: #93c5fd; padding: 0.35rem 0.65rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                                    <span>🔗</span>
                                                    <span>فتح الرابط</span>
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td style="padding: 1rem; color: #9ca3af; font-size: 0.85rem;">
                                        {{ $sub->created_at->format('Y-m-d') }}
                                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $sub->created_at->format('h:i A') }}</div>
                                    </td>

                                    <!-- Status & Score -->
                                    <td style="padding: 1rem;">
                                        <span style="display: inline-block; font-size: 0.8rem; font-weight: 800; padding: 0.25rem 0.65rem; border-radius: 9999px; background-color: {{ $sub->status === 'approved' ? 'rgba(16, 185, 129, 0.2)' : ($sub->status === 'needs_revision' ? 'rgba(245, 158, 11, 0.2)' : 'rgba(59, 130, 246, 0.2)') }}; color: {{ $sub->status === 'approved' ? '#34d399' : ($sub->status === 'needs_revision' ? '#fbbf24' : '#60a5fa') }}; border: 1px solid currentColor;">
                                            {{ $sub->status_label }}
                                        </span>
                                        @if ($sub->score !== null)
                                            <div style="font-size: 0.85rem; font-weight: 900; color: #fbbf24; margin-top: 0.25rem;">
                                                ⭐ {{ $sub->score }} / 100
                                            </div>
                                        @endif
                                        @if ($sub->feedback)
                                            <div style="font-size: 0.75rem; color: #cbd5e1; font-style: italic; margin-top: 0.2rem; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $sub->feedback }}">
                                                "{{ $sub->feedback }}"
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td style="padding: 1rem; text-align: center;">
                                        <div style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                            <button type="button" wire:click="startEvaluation({{ $sub->id }})" style="background: #4f46e5; color: white; border: none; padding: 0.4rem 0.85rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;">
                                                <span>📝</span>
                                                <span>{{ $sub->evaluated_at ? 'تعديل التقييم' : 'تقييم الواجب' }}</span>
                                            </button>

                                            <button type="button" wire:click="deleteSubmission({{ $sub->id }})" wire:confirm="هل تريد بالتأكيد حذف هذا الواجب؟" style="color: #ef4444; background: none; border: none; font-size: 1rem; cursor: pointer;" title="حذف">
                                                🗑️
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    @endif

</div>
