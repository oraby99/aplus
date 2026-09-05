<x-filament-panels::page>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.8); }
        }
        .zoom-bg {
            background: linear-gradient(180deg, #9ca3af 0%, #a78bfa 30%, #93c5fd 60%, #fbcfe8 100%);
            border-radius: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 2px solid rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            text-align: center;
            z-index: 1;
        }
        /* Stars for Zoom */
        .zoom-bg::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                radial-gradient(circle at 15% 20%, #fde047 3px, transparent 4px),
                radial-gradient(circle at 85% 15%, #fde047 2px, transparent 3px),
                radial-gradient(circle at 75% 35%, #fff 1.5px, transparent 2px),
                radial-gradient(circle at 25% 45%, #fff 2px, transparent 3px),
                radial-gradient(circle at 10% 60%, #fde047 1px, transparent 2px),
                radial-gradient(circle at 90% 65%, #fff 2px, transparent 3px);
            z-index: -2;
            animation: twinkle 4s infinite ease-in-out;
        }
        /* Clouds and Planet for Zoom */
        .zoom-bg::after {
            content: '';
            position: absolute;
            bottom: -50px; left: -10%; right: -10%;
            height: 250px;
            background-image: 
                /* The Planet */
                radial-gradient(circle at 85% 20%, #f9a8d4 30px, transparent 31px),
                /* Planet Ring */
                radial-gradient(ellipse at 85% 20%, transparent 20px, rgba(244, 114, 182, 0.5) 25px, transparent 27px),
                /* Clouds Layer 1 (Pinkish) */
                radial-gradient(circle at 10% 80%, #fce7f3 80px, transparent 81px),
                radial-gradient(circle at 30% 70%, #fce7f3 100px, transparent 101px),
                radial-gradient(circle at 50% 80%, #fce7f3 90px, transparent 91px),
                radial-gradient(circle at 70% 70%, #fce7f3 120px, transparent 121px),
                radial-gradient(circle at 90% 80%, #fce7f3 80px, transparent 81px),
                /* Clouds Layer 2 (White) */
                radial-gradient(circle at 20% 100%, #ffffff 90px, transparent 91px),
                radial-gradient(circle at 40% 90%, #ffffff 110px, transparent 111px),
                radial-gradient(circle at 60% 100%, #ffffff 100px, transparent 101px),
                radial-gradient(circle at 80% 90%, #ffffff 120px, transparent 121px);
            z-index: -1;
            filter: drop-shadow(0 -5px 10px rgba(0,0,0,0.05));
        }

        .zoom-title {
            font-size: 2.5rem; 
            font-weight: 900; 
            color: white; 
            margin-bottom: 1.5rem; 
            text-shadow: 2px 2px 0px rgba(0,0,0,0.2), 0 0 20px rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: float 4s infinite ease-in-out;
        }
        .zoom-desc {
            color: #4c1d95; 
            margin-bottom: 2.5rem; 
            max-width: 500px; 
            font-size: 1.25rem; 
            font-weight: 700; 
            background: rgba(255,255,255,0.4); 
            padding: 1.5rem; 
            border-radius: 1.5rem; 
            border: 2px dashed rgba(255,255,255,0.8);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            backdrop-filter: blur(5px);
        }
        
        .zoom-btn {
            background: rgba(255, 255, 255, 0.9); 
            color: #4338ca; 
            padding: 1rem 3rem; 
            border-radius: 9999px; 
            font-size: 1.5rem; 
            font-weight: 900; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 1rem; 
            transition: all 0.3s; 
            border: 4px solid #c7d2fe;
            box-shadow: 0 10px 25px -5px rgba(67, 56, 202, 0.4), inset 0 -4px 0 rgba(0,0,0,0.1);
        }
        .zoom-btn:hover {
            transform: scale(1.05) translateY(-4px);
            background: white;
            box-shadow: 0 15px 30px -5px rgba(67, 56, 202, 0.5), inset 0 -4px 0 rgba(0,0,0,0.05);
        }

        .zoom-info-box {
            margin-top: 2rem; 
            background: rgba(255, 255, 255, 0.6); 
            padding: 1.5rem; 
            border-radius: 1.5rem; 
            border: 2px dashed white; 
            display: inline-block; 
            backdrop-filter: blur(10px);
        }
        
        .zoom-info-text {
            color: #312e81; font-size: 1.1rem; font-weight: bold;
        }
        .zoom-info-value {
            color: #4338ca; user-select: text; background: white; padding: 0.25rem 0.75rem; border-radius: 0.5rem; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
    <div x-data="{ activeTab: 'classroom' }" class="w-full">
        <!-- Navigation Tabs -->
        <div style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem; background: rgba(31, 41, 55, 0.7); padding: 0.4rem 0.6rem; border-radius: 1rem; border: 1px solid #374151; backdrop-filter: blur(10px); width: fit-content;">
            <button 
                type="button" 
                @click="activeTab = 'classroom'"
                :style="activeTab === 'classroom' ? 'background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4); font-weight: 800;' : 'background: transparent; color: #9ca3af; font-weight: 600;'"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem; border-radius: 0.75rem; border: none; cursor: pointer; font-size: 0.95rem; transition: all 0.2s;"
            >
                <x-filament::icon icon="heroicon-o-video-camera" style="width: 1.25rem; height: 1.25rem;" />
                <span>الفصل الافتراضي والبث المباشر 🚀</span>
            </button>

            <button 
                type="button" 
                @click="activeTab = 'homework'"
                :style="activeTab === 'homework' ? 'background: linear-gradient(135deg, #2563eb, #059669); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); font-weight: 800;' : 'background: transparent; color: #9ca3af; font-weight: 600;'"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem; border-radius: 0.75rem; border: none; cursor: pointer; font-size: 0.95rem; transition: all 0.2s;"
            >
                <x-filament::icon icon="heroicon-o-arrow-up-tray" style="width: 1.25rem; height: 1.25rem;" />
                <span>تسليم الواجبات والمشاريع 📤</span>
                @php
                    $hwCount = \App\Models\Homework::where('group_id', $record->id)
                        ->when(auth()->user()?->type === 'student', fn($q) => $q->where('student_id', auth()->id()))
                        ->count();
                @endphp
                @if($hwCount > 0)
                    <span style="background: rgba(255,255,255,0.25); color: white; padding: 0.1rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: bold;">
                        {{ $hwCount }}
                    </span>
                @endif
            </button>
        </div>

        <!-- Tab 1: Virtual Classroom (Zoom) + Chat -->
        <div x-show="activeTab === 'classroom'" style="display: flex; flex-wrap: wrap; gap: 1.5rem; height: 80vh;">
            
            <!-- Video Section (Zoom Info) -->
            <div class="zoom-bg" style="flex: 1 1 0%; min-width: 300px;">
                
                <h2 class="zoom-title">
                    الفصل الافتراضي 
                    <span style="font-size: 3rem;">🚀</span>
                </h2>
                
                <p class="zoom-desc">
                    مستعد لبدء المغامرة؟ اضغط على الزر أدناه للانضمام إلى حصة البث المباشر عبر Zoom. لا تنسَ تجهيز أدواتك! 🎨
                </p>

                @if($record->zoom_link)
                    <a href="{{ $record->zoom_link }}" target="_blank" class="zoom-btn">
                        انطلق إلى الفصل الآن!
                        <x-filament::icon icon="heroicon-o-rocket-launch" style="width: 2rem; height: 2rem;" />
                    </a>

                    @if($record->zoom_meeting_id)
                        <div class="zoom-info-box">
                            <div class="zoom-info-text" style="margin-bottom: 0.75rem;">رقم الاجتماع (ID): <strong class="zoom-info-value">{{ $record->zoom_meeting_id }}</strong></div>
                            @if($record->zoom_password)
                                <div class="zoom-info-text">كلمة المرور: <strong class="zoom-info-value">{{ $record->zoom_password }}</strong></div>
                            @endif
                        </div>
                    @endif
                @else
                    <div style="background: rgba(255, 255, 255, 0.9); color: #dc2626; padding: 1.25rem 2rem; border-radius: 1.5rem; border: 4px dashed #fca5a5; display: inline-flex; align-items: center; gap: 1rem; font-weight: 900; font-size: 1.25rem; box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.2);">
                        <x-filament::icon icon="heroicon-o-face-frown" style="width: 2rem; height: 2rem;" />
                        يبدو أن المعلم يجهز الرابط السري الآن! انتظر قليلاً...
                    </div>
                @endif

            </div>

            <!-- Chat Section -->
            <div style="flex: 1 1 0%; min-width: 300px; background-color: var(--bg-color, #1f2937); border-radius: 0.75rem; border: 1px solid #374151; display: flex; flex-direction: column; overflow: hidden;">
                <div style="padding: 1rem; border-bottom: 1px solid #374151; background-color: #111827;">
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: white; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                        <x-filament::icon icon="heroicon-o-chat-bubble-left-right" style="width: 1.25rem; height: 1.25rem; color: #10b981;" />
                        {{ __('المحادثة المباشرة') }}
                    </h3>
                </div>
                
                <div style="flex: 1; overflow: hidden;">
                    @livewire('group-chat', ['group' => $record], key('chat-room-'.$record->id))
                </div>
            </div>
        </div>

        <!-- Tab 2: Homework & Projects Section -->
        <div x-show="activeTab === 'homework'" x-cloak style="width: 100%; min-height: 80vh;">
            <div style="width: 100%; background-color: var(--bg-color, #1f2937); border-radius: 1rem; border: 1px solid #374151; overflow: hidden;">
                @livewire('group-homework', ['group' => $record], key('homework-room-'.$record->id))
            </div>
        </div>
    </div>
</x-filament-panels::page>
