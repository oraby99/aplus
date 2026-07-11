@extends('layouts.app')

@section('title', 'كورساتنا | نصنع مبرمجي المستقبل')

@section('content')

<section class="py-24 bg-sky-50 relative min-h-screen overflow-hidden backdrop-blur-sm">
    <!-- Background Animated Blobs -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-primary/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary/10 rounded-full blur-3xl animate-blob" style="animation-delay: 2s"></div>
        <div class="absolute top-1/2 left-1/3 w-96 h-96 bg-accent/10 rounded-full blur-3xl animate-blob" style="animation-delay: 4s"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-blue-600 font-extrabold text-xl mb-3 tracking-wide uppercase course-title-anim">تصفح مساراتنا</h2>
        <h3 class="text-4xl md:text-5xl font-extrabold text-slate-800 mb-16 course-title-anim">جميع الكورسات المتاحة 🚀</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $colors = ['bg-white border-blue-500/30', 'bg-white border-yellow-500/30', 'bg-white border-purple-500/30', 'bg-white border-green-500/30', 'bg-white border-pink-500/30'];
                $btnColors = ['bg-blue-600 hover:bg-blue-500 shadow-blue-500/30 text-white', 'bg-yellow-600 hover:bg-yellow-500 shadow-yellow-500/30 text-white', 'bg-purple-600 hover:bg-purple-500 shadow-purple-500/30 text-white', 'bg-green-600 hover:bg-green-500 shadow-green-500/30 text-white', 'bg-pink-600 hover:bg-pink-500 shadow-pink-500/30 text-white'];
            @endphp
            @forelse(\App\Models\Course::with('levels')->get() as $index => $course)
            @php
                $cardColor = $colors[$index % count($colors)];
                $btnColor = $btnColors[$index % count($btnColors)];
            @endphp
            <div class="course-card {{ $cardColor }} rounded-[2rem] p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-4 border-2 text-right flex flex-col h-full relative overflow-hidden group">
                <!-- Decorative Circle -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-sky-50 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="w-16 h-16 bg-sky-50 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-sm border border-sky-200/50 relative z-10 animate-float" style="animation-delay: {{ $index * 0.5 }}s">
                    @if($index % 3 == 0) 💻 @elseif($index % 3 == 1) 🤖 @else 🎮 @endif
                </div>
                <h4 class="text-2xl font-bold text-slate-800 mb-3">{{ $course->title }}</h4>
                <p class="text-slate-500 mb-6 flex-grow">{{ $course->description }}</p>
                
                <div class="space-y-3 mb-8">
                    <div class="flex justify-between items-center bg-sky-50 p-3 rounded-xl">
                        <span class="text-slate-500 font-bold">المدة:</span>
                        <span class="text-slate-800 font-bold">{{ $course->duration ?? 'غير محدد' }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-sky-50 p-3 rounded-xl">
                        <span class="text-slate-500 font-bold">السعر:</span>
                        <span class="text-primary font-bold text-lg">{{ $course->price }} ج.م</span>
                    </div>
                </div>
                
                <a href="https://wa.me/{{ \App\Models\AcademyInfo::first()?->formatted_whatsapp_phone ?? '201012345678' }}?text={{ urlencode('مرحباً، أريد الاشتراك في كورس: ' . $course->title) }}" target="_blank" class="mt-auto block w-full text-center {{ $btnColor }} text-white font-bold py-3 rounded-xl shadow-lg transition-colors relative z-10">
                    سجل الآن
                </a>
            </div>
            @empty
            <div class="col-span-3 text-center text-slate-500">لا توجد كورسات متاحة حالياً.</div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        // Animate titles
        gsap.from(".course-title-anim", {
            y: -50,
            opacity: 0,
            duration: 1,
            stagger: 0.2,
            ease: "bounce.out"
        });

        // Cards are visible by default, GSAP ScrollTrigger disabled to prevent opacity issues
    });
</script>
@endpush
