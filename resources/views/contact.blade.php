@extends('layouts.app')

@section('title', 'تواصل معنا | نصنع مبرمجي المستقبل')

@section('content')

<section class="py-24 bg-sky-50 relative overflow-hidden pt-32">
    <!-- Star decorations -->
    <div class="absolute top-10 left-10 text-3xl animate-pulse">⭐</div>
    <div class="absolute bottom-10 right-10 text-3xl animate-bounce">✨</div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-sky-100">
            <!-- Form Section -->
            <div class="w-full md:w-3/5 p-8 md:p-12 text-right">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-2">يسعدنا الاستماع إليك ✉️</h2>
                <p class="text-slate-700 mb-8 font-extrabold text-base">لديك استفسار أو ترغب في تسجيل طفلك؟ نحن هنا للإجابة.</p>

                @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold flex items-center justify-end gap-2 border border-green-200">
                    {{ session('success') }} <span>✅</span>
                </div>
                @endif

                <form action="/contact" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-base font-black text-slate-800 mb-2 text-right">الاسم</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors text-right text-slate-800 font-bold" placeholder="أدخل اسمك أو اسم طفلك">
                    </div>
                    <div>
                        <label class="block text-base font-black text-slate-800 mb-2 text-right">رقم الهاتف</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors text-right text-slate-800 font-bold" placeholder="01xxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-base font-black text-slate-800 mb-2 text-right">الرسالة</label>
                        <textarea name="message" required rows="4" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors text-right text-slate-800 font-bold" placeholder="اكتب رسالتك أو استفسارك هنا..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-4 rounded-xl shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-1 text-lg">
                        إرسال الرسالة 🚀
                    </button>
                </form>
            </div>

            <!-- Info Section -->
            <div class="w-full md:w-2/5 text-white p-8 md:p-12 flex flex-col justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-yellow-400/20 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
                
                <div class="relative z-10 space-y-10 text-right">
                    <div>
                        <h3 class="text-xl font-extrabold mb-4 flex items-center justify-end gap-3">
                            العنوان 📍
                        </h3>
                        <p class="text-blue-100 font-semibold">{{ $academyInfo->address ?? 'القاهرة، مدينة نصر، شارع عباس العقاد' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold mb-4 flex items-center justify-end gap-3">
                            الهاتف 📞
                        </h3>
                        <p class="text-blue-100 font-semibold dir-ltr">{{ $academyInfo->phone ?? '+20 10 1234 5678' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold mb-4 flex items-center justify-end gap-3">
                            البريد الإلكتروني ✉️
                        </h3>
                        <p class="text-blue-100 font-semibold">{{ $academyInfo->email ?? 'info@aplusacademy.com' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
