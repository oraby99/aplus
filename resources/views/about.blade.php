@extends('layouts.app')

@section('title', 'من نحن')

@section('content')
<section class="pt-32 pb-16 relative overflow-hidden" style="background: linear-gradient(180deg, #bae6fd 0%, #e0f2fe 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-4 header-anim">عن الأكاديمية</h1>
    </div>
</section>

<section class="py-20 bg-sky-50 relative overflow-hidden">
    <!-- Star decorations -->
    <div class="absolute top-10 right-10 text-3xl animate-pulse">⭐</div>
    <div class="absolute bottom-10 left-10 text-3xl animate-bounce">✨</div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-sky-100 text-center content-anim">
            <div class="w-24 h-24 bg-yellow-400 rounded-3xl mx-auto flex items-center justify-center text-slate-900 text-4xl font-extrabold mb-8 rotate-12 shadow-lg shadow-yellow-400/30">
                A+
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 mb-6">رؤيتنا ورسالتنا</h2>
            <p class="text-xl text-slate-800 leading-loose mb-8 font-bold">
                في <span class="font-black text-blue-600 text-2xl">أكاديمية A+</span>، نؤمن بأن كل طفل يحمل بداخله مبتكراً صغيراً. 
                مهمتنا هي توفير البيئة الخصبة والأدوات اللازمة لتحويل هذا الابتكار إلى واقع، من خلال تعليمهم لغة العصر: البرمجة.
                نحن لا نعلم الأطفال كيف يكتبون الأكواد فقط، بل نعلمهم كيف يفكرون منطقياً، وكيف يحلون المشكلات، وكيف يصنعون المستقبل.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12 text-right">
                <div class="bg-sky-50/80 p-6 rounded-2xl border border-sky-200">
                    <h3 class="text-xl font-black text-blue-600 mb-3">🎯 هدفنا</h3>
                    <p class="text-slate-800 font-extrabold text-base">إعداد جيل جديد من المبرمجين والمبتكرين القادرين على قيادة ثورة التكنولوجيا في المستقبل.</p>
                </div>
                <div class="bg-sky-50/80 p-6 rounded-2xl border border-sky-200">
                    <h3 class="text-xl font-black text-amber-700 mb-3">⭐ قيمنا</h3>
                    <p class="text-slate-800 font-extrabold text-base">الابتكار، المتعة في التعلم، التفكير النقدي، والعمل بروح الفريق.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        gsap.from(".header-anim", { y: -30, opacity: 0, duration: 0.8, ease: "back.out(1.5)" });
        gsap.from(".content-anim", { y: 40, opacity: 0, duration: 0.8, delay: 0.2, ease: "power3.out" });
    });
</script>
@endpush
