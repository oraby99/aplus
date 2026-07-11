@extends('layouts.app')

@section('title', 'الرئيسية | نصنع مبرمجي المستقبل')

@section('content')

<!-- 1. Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-b from-[#7dd3fc] via-[#38bdf8] to-[#0ea5e9] pt-32 pb-40">
    
    <!-- Floating Background Elements (Simulating 3D) -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Stars -->
        <div class="absolute top-[15%] left-[10%] text-5xl animate-pulse" style="animation-duration: 3s; filter: drop-shadow(0 0 10px rgba(253,224,71,0.8));">⭐</div>
        <div class="absolute top-[10%] right-[15%] text-4xl animate-pulse" style="animation-duration: 4s; filter: drop-shadow(0 0 10px rgba(253,224,71,0.8));">⭐</div>
        <div class="absolute bottom-[25%] left-[45%] text-4xl animate-bounce" style="animation-duration: 5s; filter: drop-shadow(0 0 10px rgba(253,224,71,0.8));">⭐</div>
        
        <!-- Planet -->
        <div class="absolute bottom-[30%] right-[5%] text-7xl animate-float" style="filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));">🪐</div>
        
        <!-- Rocket -->
        <div class="absolute top-[20%] right-[45%] text-6xl animate-float" style="animation-delay: 1s; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));">🚀</div>
        
        <!-- Paper Plane -->
        <div class="absolute top-[35%] right-[2%] text-6xl animate-float" style="animation-delay: 2s; transform: rotate(-15deg); filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));">✈️</div>

        <!-- Bubbles / Dots -->
        <div class="absolute top-[20%] left-[5%] w-6 h-6 bg-pink-400 rounded-full shadow-lg shadow-pink-400/50"></div>
        <div class="absolute top-[35%] right-[10%] w-5 h-5 bg-yellow-300 rounded-full shadow-lg shadow-yellow-300/50"></div>
        <div class="absolute bottom-[40%] left-[8%] w-8 h-8 bg-green-400 rounded-full shadow-lg shadow-green-400/50"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        
        <!-- Right Content: Text -->
        <div class="text-right hero-text flex flex-col items-end">
            <!-- Small Pink Badge -->
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-400 to-pink-500 px-6 py-2 rounded-full shadow-lg text-sm font-bold text-white mb-6 border-2 border-white/20">
                <span>🚀</span> الأكاديمية الأولى لتعليم البرمجة للأطفال
            </div>
            
            <!-- Main Bubble Text -->
            <h1 class="text-6xl md:text-8xl font-poppins font-extrabold leading-[1.4] pb-4 mb-2 text-white text-center md:text-right w-full" style="text-shadow: 0 8px 0 #1e3a8a, 0 15px 25px rgba(0,0,0,0.3);">
                نصنع مبرمجي <br>
                <span class="text-yellow-300" style="text-shadow: 0 8px 0 #b45309, 0 15px 25px rgba(0,0,0,0.3);">المستقبل</span>
            </h1>
            
            <p class="text-lg md:text-xl text-white font-bold mb-10 max-w-lg leading-relaxed text-center md:text-right w-full" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                مكان ممتع يتعلم طفلك البرمجة، تصميم الألعاب، والذكاء الاصطناعي بطريقة تفاعلية ومبتكرة.
            </p>
            
            <div class="flex flex-wrap justify-center md:justify-end gap-4 w-full">
                <!-- Pink Button -->
                <button onclick="document.getElementById('trial-modal').classList.remove('hidden'); document.getElementById('trial-modal').classList.add('flex');" class="bg-gradient-to-r from-pink-400 to-pink-500 text-white font-extrabold text-2xl px-10 py-5 rounded-full shadow-[0_8px_0_#be185d,0_15px_20px_rgba(0,0,0,0.3)] transition-all hover:-translate-y-2 hover:shadow-[0_12px_0_#be185d,0_20px_25px_rgba(0,0,0,0.4)] active:translate-y-2 active:shadow-[0_0px_0_#be185d,0_5px_10px_rgba(0,0,0,0.4)] flex items-center gap-3">
                    احجز حصتك التجريبية 🚀
                </button>
                
                <!-- Green Button -->
                <a href="#game-section" class="bg-gradient-to-r from-green-400 to-green-500 text-white font-extrabold text-xl px-8 py-5 rounded-full shadow-[0_6px_0_#15803d,0_10px_15px_rgba(0,0,0,0.3)] transition-all hover:-translate-y-1 hover:shadow-[0_8px_0_#15803d,0_15px_20px_rgba(0,0,0,0.4)] active:translate-y-1 active:shadow-[0_0px_0_#15803d,0_5px_10px_rgba(0,0,0,0.4)] flex items-center gap-2">
                    العب معنا 🎮
                </a>
            </div>
        </div>
        
        <!-- Left Content: Framed Image -->
        <div class="relative hero-image mt-16 lg:mt-0 flex justify-center lg:justify-start">
            <!-- Big Yellow Star top left -->
            <div class="absolute -top-12 -left-8 text-7xl z-20 animate-wiggle" style="filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));">⭐</div>
            <!-- Big Yellow Star bottom right -->
            <div class="absolute -bottom-10 -right-8 text-7xl z-20 animate-wiggle" style="animation-delay: 1s; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));">⭐</div>

            <!-- Frame -->
            <div class="relative bg-white p-3 rounded-[2rem] shadow-2xl transform hover:scale-105 transition-transform duration-500 z-10 w-full max-w-xl">
                <div class="border-4 border-yellow-400 rounded-[1.5rem] overflow-hidden relative">
                    <img src="{{ asset('images/hero.png') }}" alt="طالب A+ Academy" class="w-full h-auto object-cover" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                </div>
                
                <!-- Purple Floating Badge -->
                <div class="absolute -bottom-8 -left-4 bg-gradient-to-r from-purple-500 to-indigo-500 p-4 rounded-3xl shadow-[0_8px_0_#4c1d95,0_15px_25px_rgba(0,0,0,0.3)] flex flex-col items-center justify-center text-white border-2 border-white/20 w-32 animate-float">
                    <div class="text-3xl bg-white rounded-full p-2 mb-1 shadow-inner">🏆</div>
                    <div class="font-bold text-xl leading-none mt-1">1000+</div>
                    <div class="text-sm font-bold opacity-90">طفل مبدع</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Clouds Divider -->
    <div class="absolute bottom-0 left-0 w-full leading-none z-20">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="w-full h-32 md:h-48" style="fill: #ffffff;">
            <path d="M0,120 L1200,120 L1200,70 C1150,50 1100,60 1050,40 C1000,20 950,50 900,40 C850,30 800,60 750,40 C700,20 650,50 600,40 C550,30 500,60 450,40 C400,20 350,50 300,40 C250,30 200,60 150,40 C100,20 50,50 0,70 Z"></path>
        </svg>
    </div>
    
</section>

<!-- Feature Icons Row (below hero) -->
<div class="relative z-30 px-4 -mt-6 sm:-mt-10 mb-10">
    <div class="max-w-5xl mx-auto bg-white/95 backdrop-blur-md rounded-3xl md:rounded-full shadow-xl border border-white/60 p-4 md:p-5 grid grid-cols-2 md:flex md:flex-nowrap md:justify-around items-center gap-4 md:gap-6">
        <!-- Icon 1 -->
        <div class="flex items-center gap-3 justify-center md:justify-start">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl shadow-sm flex-shrink-0">💻</div>
            <div class="font-bold text-slate-800 text-xs md:text-base leading-tight">برمجة سهلة<br>وممتعة</div>
        </div>
        <!-- Icon 2 -->
        <div class="flex items-center gap-3 justify-center md:justify-start">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-indigo-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl shadow-sm flex-shrink-0">🎮</div>
            <div class="font-bold text-slate-800 text-xs md:text-base leading-tight">تصميم ألعاب<br>تفاعلية</div>
        </div>
        <!-- Icon 3 -->
        <div class="flex items-center gap-3 justify-center md:justify-start">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-purple-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl shadow-sm flex-shrink-0">🤖</div>
            <div class="font-bold text-slate-800 text-xs md:text-base leading-tight">تعلم الذكاء<br>الاصطناعي</div>
        </div>
        <!-- Icon 4 -->
        <div class="flex items-center gap-3 justify-center md:justify-start">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl shadow-sm flex-shrink-0">💡</div>
            <div class="font-bold text-slate-800 text-xs md:text-base leading-tight">تنمية التفكير<br>والإبداع</div>
        </div>
    </div>
</div>

<!-- 2. Features/About -->
<section class="pt-32 pb-24 bg-white relative" id="about">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-blue-600 font-extrabold text-xl mb-3 tracking-wide uppercase">من نحن</h2>
        <h3 class="text-4xl md:text-5xl font-bold text-slate-800 mb-8">اكتشف عالم A+ Academy</h3>
        <p class="text-lg text-slate-600 max-w-3xl mx-auto mb-12">
            {{ $academyInfo->about_text ?? 'نحن نؤمن أن كل طفل لديه القدرة على الابتكار. في A+ Academy، لا نعلمهم فقط كتابة الأكواد، بل نعلمهم كيفية التفكير المنهجي وحل المشكلات وصنع ألعابهم الخاصة بدلاً من مجرد لعبها.' }}
        </p>
        
        <div class="relative max-w-4xl mx-auto rounded-3xl overflow-hidden shadow-2xl group cursor-pointer video-container" onclick="document.getElementById('video-modal').classList.remove('hidden'); document.getElementById('video-modal').classList.add('flex');">
            <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="فيديو تعريفي" class="w-full h-[400px] md:h-[500px] object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center transition-colors group-hover:bg-black/40">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl transform transition-transform group-hover:scale-110">
                    <svg class="w-8 h-8 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div id="video-modal" class="fixed inset-0 z-[100] hidden items-center justify-center">
            <div class="absolute inset-0 bg-sky-100 backdrop-blur-sm" onclick="document.getElementById('video-modal').classList.add('hidden'); document.getElementById('video-modal').classList.remove('flex'); var v = document.getElementById('promo-video'); if(v) v.pause();"></div>
            <div class="relative z-10 w-full max-w-4xl mx-4">
                <button onclick="document.getElementById('video-modal').classList.add('hidden'); document.getElementById('video-modal').classList.remove('flex'); var v = document.getElementById('promo-video'); if(v) v.pause();" class="absolute -top-12 left-0 text-white hover:text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl border border-white/10 flex items-center justify-center">
                    @if($academyInfo?->video_url)
                        <video id="promo-video" class="w-full h-full" controls controlsList="nodownload">
                            <source src="{{ asset('storage/' . $academyInfo->video_url) }}" type="video/mp4">
                            متصفحك لا يدعم تشغيل الفيديو.
                        </video>
                    @else
                        <div class="text-white text-lg">لا يوجد فيديو تعريفي حالياً</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Why Choose Us - Kids Style -->
<section class="py-20 relative overflow-hidden" style="background: linear-gradient(180deg, #e0f2fe 0%, #bae6fd 50%, #7dd3fc 100%);">
    <!-- Decorative stars -->
    <div class="absolute top-8 right-10 text-4xl animate-pulse" style="animation-duration:3s;">⭐</div>
    <div class="absolute top-16 left-8 text-3xl animate-bounce" style="animation-duration:4s;">✨</div>
    <div class="absolute bottom-10 right-20 text-4xl animate-pulse" style="animation-duration:2s;">⭐</div>
    <div class="absolute bottom-8 left-16 text-2xl animate-bounce" style="animation-duration:5s;">✨</div>
    <!-- Pencils decoration -->
    <div class="absolute top-4 left-1/4 text-3xl" style="transform: rotate(-20deg);">✏️</div>
    <div class="absolute bottom-4 right-1/4 text-3xl" style="transform: rotate(20deg);">✏️</div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="font-extrabold text-2xl mb-2" style="color: #d97706;">لماذا تختارنا؟</h2>
        <h3 class="text-4xl md:text-5xl font-extrabold mb-16" style="color: #1e3a8a; text-shadow: 0 3px 0 rgba(0,0,0,0.15);">بيئة تعليمية مصممة خصيصاً للأطفال</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1: Blue - تعليم باللعب -->
            <div class="rounded-[2.5rem] p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 cursor-default" style="background: #60a5fa; border: 4px solid #3b82f6;">
                <div class="text-6xl mb-5">🎮</div>
                <h4 class="text-2xl font-extrabold text-white mb-4">تعليم باللعب</h4>
                <p class="text-blue-50 font-semibold text-base leading-relaxed">نستخدم أساليب التلعيب (Gamification) لضمان عدم شعور الطفل بالملل أثناء تعلم المفاهيم المعقدة.</p>
            </div>
            <!-- Card 2: Yellow - مهندسون محترفون (center, taller) -->
            <div class="rounded-[2.5rem] p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 cursor-default md:-mt-6" style="background: #fde047; border: 4px solid #eab308;">
                <div class="text-6xl mb-5">👨‍🏫</div>
                <h4 class="text-2xl font-extrabold text-slate-800 mb-4">مهندسون محترفون</h4>
                <p class="text-slate-700 font-semibold text-base leading-relaxed">مدربونا ليسوا فقط مبرمجين، بل خبراء في التعامل مع الأطفال وإيصال المعلومة بطرق بسيطة ومحببة.</p>
            </div>
            <!-- Card 3: Green - تطبيق عملي -->
            <div class="rounded-[2.5rem] p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 cursor-default" style="background: #4ade80; border: 4px solid #22c55e;">
                <div class="text-6xl mb-5">🚀</div>
                <h4 class="text-2xl font-extrabold text-white mb-4">تطبيق عملي 100%</h4>
                <p class="text-green-50 font-semibold text-base leading-relaxed">الطفل يبني مشروعه الخاص من اليوم الأول. سيعود للمنزل وهو فخور بلعبة أو موقع صممه بنفسه.</p>
            </div>
        </div>
    </div>
    <!-- Cloud bottom -->
    <div class="absolute bottom-0 left-0 w-full leading-none z-20">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none" class="w-full h-16" style="fill:#f0f9ff;"><path d="M0,60 L1200,60 L1200,30 C1150,10 1100,40 1050,20 C1000,0 950,30 900,20 C850,10 800,40 750,20 C700,0 650,30 600,20 C550,10 500,40 450,20 C400,0 350,30 300,20 C250,10 200,40 150,20 C100,0 50,30 0,30 Z"></path></svg>
    </div>
</section>


<!-- 4. Top Courses - Adventure Map Style -->
<section class="py-20 relative overflow-hidden" style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #3b82f6 100%);" id="courses">
    <!-- Decorative stars -->
    <div class="absolute top-10 left-10 text-4xl animate-pulse" style="animation-duration:3s;">⭐</div>
    <div class="absolute top-10 right-10 text-3xl animate-pulse" style="animation-duration:4s;">⭐</div>
    <div class="absolute bottom-10 left-20 text-2xl animate-bounce" style="animation-duration:5s;">✨</div>
    <div class="absolute bottom-10 right-16 text-3xl animate-bounce" style="animation-duration:3.5s;">🌟</div>
    <!-- Compass decorations -->
    <div class="absolute top-1/2 left-4 text-5xl opacity-20">🧭</div>
    <div class="absolute top-1/2 right-4 text-5xl opacity-20">🗺️</div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="font-extrabold text-2xl mb-3" style="color: #fde047;">رحلة البطل 🗺️</h2>
        <h3 class="text-4xl md:text-5xl font-extrabold mb-16 text-white" style="text-shadow: 0 4px 0 rgba(0,0,0,0.2);">مسار التعلم (Learning Path)</h3>

        <!-- Adventure Path -->
        <div class="relative">
            @php $courseEmojis = ['🐍','🚀','🤖','🎮','💻','🌟','🏆','🎯']; @endphp
            @forelse($courses as $index => $course)

            <!-- Course Stop -->
            <div class="relative mb-16 {{ $index % 2 == 0 ? 'text-right' : 'text-left' }}">
                <!-- Dashed path line to next (not last) -->
                @if(!$loop->last)
                <div class="absolute {{ $index % 2 == 0 ? 'left-1/4' : 'right-1/4' }} bottom-[-3.5rem] w-1 h-14 border-l-4 border-dashed border-white/40 z-0"></div>
                @endif

                <div class="flex items-center gap-6 {{ $index % 2 == 0 ? 'flex-row-reverse md:flex-row justify-end' : 'flex-row justify-start' }}">
                    <!-- Number circle -->
                    <div class="flex-shrink-0 w-20 h-20 rounded-full bg-white shadow-2xl flex items-center justify-center font-extrabold text-3xl" style="color: #1d4ed8; border: 5px solid #fde047;">{{ $index + 1 }}</div>

                    <!-- Scroll card -->
                    <div class="cursor-pointer group max-w-xs md:max-w-sm flex-grow rounded-3xl p-6 shadow-2xl hover:shadow-yellow-400/30 hover:-translate-y-2 transition-all duration-300 text-right" style="background: #fefce8; border: 3px solid #fde047;" onclick="document.getElementById('modal-{{$course->id}}').classList.remove('hidden'); document.getElementById('modal-{{$course->id}}').classList.add('flex');">
                        <div class="text-4xl mb-3">{{ $courseEmojis[$index % count($courseEmojis)] }}</div>
                        <h4 class="text-xl font-extrabold mb-2" style="color: #1e3a8a;">{{ $course->title }}</h4>
                        <p class="text-slate-600 text-sm mb-4">{{ Str::limit($course->description, 60) }}</p>
                        <span class="inline-block font-extrabold px-5 py-2 rounded-full text-white text-sm" style="background: #2563eb;">استكشف الكورس ←</span>
                    </div>
                </div>
            </div>

            <!-- Course Modal -->
            <div id="modal-{{$course->id}}" class="fixed inset-0 z-[100] hidden items-center justify-center">
                <div class="absolute inset-0 bg-slate-800/50 backdrop-blur-sm" onclick="document.getElementById('modal-{{$course->id}}').classList.add('hidden'); document.getElementById('modal-{{$course->id}}').classList.remove('flex');"></div>
                <div class="bg-white rounded-3xl p-8 max-w-lg w-full relative z-10 text-slate-800 text-right m-4 transform transition-all">
                    <button onclick="document.getElementById('modal-{{$course->id}}').classList.add('hidden'); document.getElementById('modal-{{$course->id}}').classList.remove('flex');" class="absolute top-4 left-4 text-slate-500 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <h4 class="text-2xl font-bold text-primary mb-4">{{ $course->title }}</h4>
                    <p class="text-slate-600 mb-6">{{ $course->description }}</p>
                    <div class="bg-sky-50 rounded-xl p-4 mb-6 border border-sky-200">
                        <p class="font-bold text-slate-800 mb-2">مدة الكورس: <span class="text-primary">{{ $course->duration ?? 'سيتم التحديد قريباً' }}</span></p>
                        <p class="font-bold text-slate-800">السعر: <span class="text-primary">{{ $course->price }} ج.م</span></p>
                    </div>
                    
                    @if(count($course->levels) > 0)
                    <div class="mb-6 text-right">
                        <p class="font-extrabold text-slate-800 mb-3 text-base border-r-4 border-yellow-400 pr-2">مراحل / مستويات الكورس:</p>
                        <div class="space-y-2">
                            @foreach($course->levels as $level)
                            <div class="flex items-center gap-3 bg-sky-50/50 p-3 rounded-2xl border border-sky-100">
                                <span class="w-7 h-7 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shadow-md">{{ $loop->iteration }}</span>
                                <span class="font-bold text-slate-800 text-sm">{{ $level->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <a href="https://wa.me/{{ \App\Models\AcademyInfo::first()?->formatted_whatsapp_phone ?? '201012345678' }}?text={{ urlencode('مرحباً، أريد الاشتراك في كورس: ' . $course->title) }}" target="_blank" class="block w-full text-center bg-secondary hover:bg-yellow-500 text-white font-bold py-3 rounded-xl transition-colors">
                        اشترك الآن 🚀
                    </a>
                </div>
            </div>

            @empty
            <div class="text-center text-white/60 text-xl">جاري إضافة الكورسات للمسار... 🗺️</div>
            @endforelse

            <!-- Final Treasure -->
            @if(count($courses) > 0)
            <div class="text-center mt-8">
                <div class="text-7xl animate-bounce" style="animation-duration:2s;">🏆</div>
                <div class="mt-4 inline-block px-8 py-3 rounded-full font-extrabold text-lg" style="background: #fde047; color: #1e3a8a;">الخطوة الأخيرة - رحلتك اكتملت! 🎉</div>
            </div>
            @endif
        </div>
    </div>
</section>


<!-- 5. Learning Path -->
<section class="py-24 bg-sky-50 backdrop-blur-md relative overflow-hidden">
    <div class="absolute left-10 top-10 w-48 h-48 bg-purple-200 rounded-full mix-blend-multiply filter blur-2xl opacity-40 animate-blob"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-blue-600 font-extrabold text-xl mb-3 tracking-wide uppercase">من سيعلم طفلك؟</h2>
        <h3 class="text-4xl md:text-5xl font-bold text-slate-800 mb-16">تعرف على مدربينا</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($teachers as $teacher)
            <div class="teacher-card group perspective">
                <div class="relative preserve-3d transition-transform duration-700 w-full h-80 group-hover:rotate-y-180">
                    <!-- Front -->
                    <div class="absolute inset-0 backface-hidden bg-white rounded-3xl p-8 flex flex-col items-center justify-center shadow-lg border border-sky-200">
                        <div class="w-32 h-32 bg-primary/10 rounded-full mb-6 flex items-center justify-center">
                            <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800">{{ $teacher->name }}</h4>
                        <p class="text-primary font-bold mt-2">مهندس برمجيات</p>
                    </div>
                    <!-- Back -->
                    <div class="absolute inset-0 backface-hidden rotate-y-180 bg-primary text-white rounded-3xl p-8 flex flex-col items-center justify-center shadow-xl">
                        <h4 class="text-2xl font-bold mb-4">{{ $teacher->name }}</h4>
                        <p class="text-blue-100 text-center text-sm leading-relaxed mb-6">
                            متخصص في تعليم الأطفال كيفية بناء تطبيقات تفاعلية وتحويل خيالهم إلى حقيقة برمجية.
                        </p>
                        <a href="https://wa.me/{{ \App\Models\AcademyInfo::first()?->formatted_whatsapp_phone ?? '201012345678' }}?text={{ urlencode('مرحباً، أريد التواصل مع المهندس: ' . $teacher->name) }}" target="_blank" class="bg-secondary text-white font-bold px-6 py-2 rounded-full text-sm hover:bg-yellow-400 transition-colors">
                            تواصل معه
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-slate-500">سيتم إضافة المهندسين قريباً...</div>
            @endforelse
        </div>
    </div>
</section>

<!-- 6. Student Projects -->
<section class="py-24 bg-sky-100 relative overflow-hidden backdrop-blur-md">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-blue-600 font-extrabold text-xl mb-3 tracking-wide uppercase">إنجازات أبطالنا</h2>
        <h3 class="text-4xl md:text-5xl font-bold mb-16 text-slate-900">مشاريع الطلاب</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
            <div class="project-card relative group overflow-hidden rounded-3xl bg-white border border-sky-200">
                @if($project->image_path)
                <img src="{{ Str::startsWith($project->image_path, ['http://', 'https://']) ? $project->image_path : asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                <div class="w-full h-64 bg-white flex items-center justify-center border border-sky-200 transition-transform duration-700 group-hover:scale-110">
                    <span class="text-6xl">💻</span>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <h4 class="text-xl font-black text-white mb-1">{{ $project->title }}</h4>
                    <p class="text-yellow-300 font-bold text-sm mb-3">بواسطة: {{ $project->student->name }}</p>
                    @if($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" class="text-primary hover:text-white transition-colors text-sm font-bold flex items-center gap-1">
                        شاهد المشروع <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-slate-500 py-12 border border-dashed border-sky-200 rounded-3xl">لا توجد مشاريع مضافة حتى الآن.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- 7. Competitions & Events -->
@if(count($competitions) > 0)
<section class="py-24 bg-sky-50 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-secondary font-bold mb-2">تحديات مستمرة</h2>
        <h3 class="text-4xl md:text-5xl font-bold text-slate-800 mb-16">المسابقات والهاكاثون</h3>
        
        <div class="max-w-4xl mx-auto">
            @foreach($competitions as $competition)
            <div class="bg-white rounded-3xl p-8 shadow-xl border-l-8 border-primary text-right mb-6 transform transition-transform hover:-translate-y-1">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="inline-block px-3 py-1 rounded-full text-xs font-bold mb-3 {{ $competition->status == 'ongoing' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $competition->status == 'ongoing' ? 'جارية الآن' : 'قادمة قريباً' }}
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800">{{ $competition->title }}</h4>
                        <p class="text-slate-600 mt-2">{{ Str::limit($competition->description, 100) }}</p>
                    </div>
                    <div class="text-right md:text-left bg-sky-50 p-4 rounded-xl min-w-[200px]">
                        <p class="text-sm text-slate-500 font-bold mb-1">يبدأ في:</p>
                        <p class="text-primary font-bold text-lg">{{ \Carbon\Carbon::parse($competition->start_date)->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 8. Testimonials -->
<section class="py-24 bg-sky-50 backdrop-blur-md overflow-hidden" id="testimonials-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-blue-600 font-extrabold text-xl mb-3 tracking-wide uppercase">قصص النجاح</h2>
        <h3 class="text-4xl md:text-5xl font-bold text-slate-800 mb-16">آراء أولياء الأمور</h3>
        
        <!-- Add Testimonial Button -->
        <div class="mb-12">
            <button onclick="document.getElementById('testimonial-modal').classList.remove('hidden'); document.getElementById('testimonial-modal').classList.add('flex');" class="bg-primary hover:bg-blue-600 text-white font-bold text-lg px-8 py-4 rounded-full shadow-lg shadow-primary/30 transition-transform hover:-translate-y-1 inline-flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                أضف تقييمك
            </button>
            
            @if(session('testimonial_success'))
            <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-xl max-w-2xl mx-auto font-bold border border-green-200">
                {{ session('testimonial_success') }}
            </div>
            @endif
        </div>

        <!-- Display Testimonials -->
        <div class="flex flex-wrap justify-center gap-8">
            @php 
                // Use testimonials if they exist, otherwise fallback to evaluations
                $displayItems = count($testimonials) > 0 ? $testimonials : $evaluations;
            @endphp
            
            @forelse($displayItems as $item)
            <div class="bg-white p-8 rounded-3xl shadow-lg w-full md:w-[400px] text-right border border-sky-200">
                <div class="flex text-secondary mb-4 text-xl">
                    @php 
                        // Handle both 1-5 scale (testimonials) and 1-100 scale (evaluations fallback)
                        $score = isset($item->is_approved) ? $item->score : max(1, min(5, round($item->score / 20))); 
                    @endphp
                    @for($i = 0; $i < $score; $i++) ★ @endfor
                    @for($i = 0; $i < (5 - $score); $i++) <span class="text-slate-600">★</span> @endfor
                </div>
                <p class="text-slate-600 mb-6 italic">"{{ $item->feedback ?? 'أكاديمية رائعة ومستوى تعليمي متميز!' }}"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center font-bold">
                        {{ mb_substr($item->name ?? $item->student?->name ?? 'ط', 0, 1) }}
                    </div>
                    <div>
                        <h5 class="font-bold text-slate-800">{{ $item->name ?? $item->student?->name ?? 'طالب' }}</h5>
                        <p class="text-sm text-slate-500">{{ $item->course_name ?? $item->course?->title ?? 'كورس البرمجة' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-slate-500 w-full">كن أول من يضيف تقييماً للأكاديمية!</div>
            @endforelse
        </div>
        
        <!-- Testimonial Form Modal -->
        <div id="testimonial-modal" class="fixed inset-0 z-[100] hidden items-center justify-center">
            <div class="absolute inset-0 bg-slate-800/50 backdrop-blur-sm" onclick="document.getElementById('testimonial-modal').classList.add('hidden'); document.getElementById('testimonial-modal').classList.remove('flex');"></div>
            <div class="bg-white rounded-3xl p-8 max-w-lg w-full relative z-10 text-right m-4 transform transition-all shadow-2xl">
                <button onclick="document.getElementById('testimonial-modal').classList.add('hidden'); document.getElementById('testimonial-modal').classList.remove('flex');" class="absolute top-4 left-4 text-slate-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h4 class="text-2xl font-bold text-white mb-2">أضف تقييمك</h4>
                <p class="text-slate-300 mb-6">رأيك يهمنا ويساعدنا في تطوير الأكاديمية.</p>
                
                <form action="/testimonials" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-1">الاسم (ولي الأمر أو الطالب)</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-1">اسم الكورس (اختياري)</label>
                        <input type="text" name="course_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-1">التقييم (النجوم)</label>
                        <select name="score" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-secondary font-bold text-lg">
                            <option value="5" class="text-secondary">★★★★★ (ممتاز)</option>
                            <option value="4" class="text-secondary">★★★★ (جيد جداً)</option>
                            <option value="3" class="text-secondary">★★★ (جيد)</option>
                            <option value="2" class="text-secondary">★★ (مقبول)</option>
                            <option value="1" class="text-secondary">★ (ضعيف)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-1">رأيك (ملاحظاتك)</label>
                        <textarea name="feedback" required rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-primary hover:bg-blue-600 text-white font-bold py-4 rounded-xl transition-colors mt-4">
                        إرسال التقييم
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- 9. Mini Game Section (Catch the Bug) -->
<section class="py-24 bg-sky-100 backdrop-blur-md relative overflow-hidden" id="game-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-blue-600 font-extrabold text-xl mb-3 tracking-wide uppercase">وقت المرح!</h2>
        <h3 class="text-4xl font-bold mb-6 text-slate-900">لعبة صائد الأخطاء البرمجية (Bugs) 🐛</h3>
        <p class="text-slate-500 mb-8 max-w-2xl mx-auto">ساعد المهندس في صيد الأخطاء البرمجية (Bugs) التي تظهر على الشاشة قبل أن تهرب! اضغط عليها بسرعة.</p>
        
        <div class="bg-slate-900 rounded-3xl p-4 md:p-8 max-w-4xl mx-auto shadow-2xl border border-sky-200 relative">
            <div class="flex justify-between items-center mb-4 px-4">
                <div class="text-xl font-bold">النقاط: <span id="score" class="text-secondary text-3xl">0</span></div>
                <div class="text-xl font-bold">الوقت: <span id="timer" class="text-primary text-3xl">30</span>ث</div>
            </div>
            
            <div id="game-board" class="w-full h-[400px] bg-white rounded-2xl relative overflow-hidden cursor-crosshair border-2 border-sky-200">
                <!-- Start Overlay -->
                <div id="game-start-overlay" class="absolute inset-0 bg-sky-100 flex flex-col items-center justify-center z-20">
                    <button id="start-btn" class="bg-primary hover:bg-blue-600 text-white font-bold text-2xl px-10 py-4 rounded-full shadow-lg shadow-primary/50 transition-transform hover:scale-110">
                        ابدأ اللعبة 🎮
                    </button>
                </div>
                
                <!-- Game Over Overlay -->
                <div id="game-over-overlay" class="absolute inset-0 bg-sky-100 flex flex-col items-center justify-center z-20 hidden">
                    <h4 class="text-4xl font-bold mb-2">انتهى الوقت!</h4>
                    <p class="text-xl text-slate-600 mb-6">لقد اصطدت <span id="final-score" class="text-secondary font-bold text-3xl">0</span> Bugs!</p>
                    <button id="restart-btn" class="bg-secondary hover:bg-yellow-500 text-white font-bold text-xl px-8 py-3 rounded-full shadow-lg transition-transform hover:scale-105">
                        العب مرة أخرى 🔄
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    .perspective { perspective: 1000px; }
    .preserve-3d { transform-style: preserve-3d; }
    .backface-hidden { backface-visibility: hidden; }
    .rotate-y-180 { transform: rotateY(180deg); }
    
    /* Bug Animation */
    @keyframes wiggle {
        0%, 100% { transform: rotate(-10deg); }
        50% { transform: rotate(10deg); }
    }
    
    /* Animation Delays for Blobs */
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    .bug { animation: wiggle 0.5s ease-in-out infinite; }
</style>

<!-- Confetti JS -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // GSAP Animations
        gsap.registerPlugin(ScrollTrigger);

        // Confetti on load
        setTimeout(() => {
            confetti({
                particleCount: 150,
                spread: 100,
                origin: { y: 0.6 },
                colors: ['#3B82F6', '#FDE047', '#A855F7', '#4ADE80']
            });
        }, 1000);

        // Hero Section
        gsap.from(".hero-text > *", {
            y: 50,
            opacity: 0,
            duration: 1,
            stagger: 0.2,
            ease: "back.out(1.7)"
        });

        gsap.from(".hero-image", {
            x: -100,
            opacity: 0,
            duration: 1.5,
            delay: 0.5,
            ease: "power3.out"
        });

        // Floating Elements
        gsap.to(".float-item", {
            y: "random(-30, 30)",
            x: "random(-30, 30)",
            rotation: "random(-20, 20)",
            duration: "random(2, 4)",
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // Scroll Animations removed to prevent opacity bugs

        // ===== BUG CATCHER GAME LOGIC =====
        const gameBoard = document.getElementById('game-board');
        const startBtn = document.getElementById('start-btn');
        const restartBtn = document.getElementById('restart-btn');
        const startOverlay = document.getElementById('game-start-overlay');
        const gameOverOverlay = document.getElementById('game-over-overlay');
        const scoreDisplay = document.getElementById('score');
        const timerDisplay = document.getElementById('timer');
        const finalScoreDisplay = document.getElementById('final-score');
        
        let score = 0;
        let timeLeft = 30;
        let gameInterval;
        let bugSpawner;
        let isPlaying = false;

        const emojis = ['🐛', '🐜', '🕷️', '🦠'];

        function startGame() {
            score = 0;
            timeLeft = 30;
            isPlaying = true;
            scoreDisplay.textContent = score;
            timerDisplay.textContent = timeLeft;
            
            startOverlay.classList.add('hidden');
            gameOverOverlay.classList.add('hidden');
            gameBoard.innerHTML = ''; // Clear bugs
            gameBoard.appendChild(startOverlay); // Keep overlays in DOM
            gameBoard.appendChild(gameOverOverlay);
            
            gameInterval = setInterval(updateTimer, 1000);
            spawnBug();
            bugSpawner = setInterval(spawnBug, 800);
        }

        function updateTimer() {
            timeLeft--;
            timerDisplay.textContent = timeLeft;
            if (timeLeft <= 0) {
                endGame();
            }
        }

        function spawnBug() {
            if (!isPlaying) return;
            
            const bug = document.createElement('div');
            bug.className = 'bug absolute text-4xl cursor-pointer select-none';
            bug.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            
            // Random position within bounds
            const maxX = gameBoard.clientWidth - 50;
            const maxY = gameBoard.clientHeight - 50;
            const randomX = Math.floor(Math.random() * maxX);
            const randomY = Math.floor(Math.random() * maxY);
            
            bug.style.left = randomX + 'px';
            bug.style.top = randomY + 'px';
            
            bug.addEventListener('mousedown', () => catchBug(bug));
            bug.addEventListener('touchstart', (e) => { e.preventDefault(); catchBug(bug); });
            
            gameBoard.appendChild(bug);
            
            // Remove bug after random time if not caught
            setTimeout(() => {
                if (bug.parentNode && isPlaying) {
                    bug.remove();
                }
            }, Math.random() * 1500 + 1000);
        }

        function catchBug(bug) {
            if (!isPlaying) return;
            
            // Show +1 animation
            const plusOne = document.createElement('div');
            plusOne.className = 'absolute text-secondary font-bold text-xl pointer-events-none';
            plusOne.textContent = '+1';
            plusOne.style.left = bug.style.left;
            plusOne.style.top = bug.style.top;
            gameBoard.appendChild(plusOne);
            
            gsap.to(plusOne, {y: -50, opacity: 0, duration: 1, onComplete: () => plusOne.remove()});
            
            bug.remove();
            score++;
            scoreDisplay.textContent = score;
            
            // Optional: increase difficulty
            if(score % 10 === 0) {
                clearInterval(bugSpawner);
                bugSpawner = setInterval(spawnBug, Math.max(300, 800 - (score * 10)));
            }
        }

        function endGame() {
            isPlaying = false;
            clearInterval(gameInterval);
            clearInterval(bugSpawner);
            
            // Remove all active bugs
            document.querySelectorAll('.bug').forEach(b => b.remove());
            
            finalScoreDisplay.textContent = score;
            gameOverOverlay.classList.remove('hidden');
        }

        startBtn.addEventListener('click', startGame);
        restartBtn.addEventListener('click', startGame);
    });
</script>
@endpush
