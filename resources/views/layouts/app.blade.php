<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+ Academy | @yield('title', 'نصنع مبرمجي المستقبل')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</head>
<body class="bg-sky-50 text-slate-900 font-sans selection:bg-pink-500 selection:text-white relative overflow-x-hidden">
    <div class="overflow-x-hidden w-full relative min-h-screen flex flex-col">
    <!-- Navbar -->
    @php
        $academyInfo = \App\Models\AcademyInfo::first();
    @endphp
    <div class="fixed w-full z-50 px-4 sm:px-6 lg:px-8 top-4 flex justify-center pointer-events-none">
        <nav class="w-full max-w-6xl bg-white/90 backdrop-blur-md rounded-3xl shadow-lg border border-white/50 pointer-events-auto" id="navbar">
            <!-- Desktop + Mobile Top Row -->
            <div class="flex justify-between items-center h-20 px-6 md:px-8">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo.png') }}" alt="A+ Academy Logo" class="h-16 w-auto object-contain drop-shadow-sm group-hover:rotate-12 transition-transform duration-300" onerror="this.outerHTML='<div class=&quot;w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-primary/30 group-hover:rotate-12 transition-transform&quot;>A+</div>'">
                        <span class="font-poppins font-bold text-3xl tracking-tight text-slate-900">
                            <span class="text-primary">A+</span> Academy
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-12">
                    <a href="/" class="text-slate-800 hover:text-blue-600 font-extrabold text-lg transition-colors">{{ __('الرئيسية') }}</a>
                    <a href="/courses" class="text-slate-600 hover:text-blue-600 font-extrabold text-lg transition-colors">{{ __('كورساتنا') }}</a>
                    <a href="/#about" class="text-slate-600 hover:text-blue-600 font-extrabold text-lg transition-colors">{{ __('من نحن') }}</a>
                </div>

                <!-- Desktop CTA Button & Lang Switcher -->
                <div class="hidden md:flex items-center gap-3">
                    @if(app()->getLocale() == 'ar')
                        <a href="/lang/en" class="text-slate-600 hover:text-blue-600 font-bold px-3 py-2 rounded-lg hover:bg-slate-100 transition-colors">English</a>
                    @else
                        <a href="/lang/ar" class="text-slate-600 hover:text-blue-600 font-bold px-3 py-2 rounded-lg hover:bg-slate-100 transition-colors">عربي</a>
                    @endif
                    <button onclick="document.getElementById('trial-modal').classList.remove('hidden'); document.getElementById('trial-modal').classList.add('flex');" class="bg-pink-500 hover:bg-pink-600 text-white font-extrabold px-6 py-3 rounded-full shadow-lg shadow-pink-500/20 transition-all hover:-translate-y-1 hover:scale-105 text-base">
                        {{ __('حصة تجريبية مجانية') }} 🚀
                    </button>
                    <a href="/contact" class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold px-6 py-3 rounded-full shadow-lg shadow-yellow-400/40 transition-all hover:-translate-y-1 hover:scale-105 text-base">
                        {{ __('تواصل معنا') }}
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="w-10 h-10 flex flex-col items-center justify-center gap-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 transition-colors focus:outline-none" aria-label="Toggle menu">
                        <span id="bar1" class="block w-6 h-0.5 bg-slate-800 rounded-full transition-all duration-300"></span>
                        <span id="bar2" class="block w-6 h-0.5 bg-slate-800 rounded-full transition-all duration-300"></span>
                        <span id="bar3" class="block w-6 h-0.5 bg-slate-800 rounded-full transition-all duration-300"></span>
                    </button>
                </div>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div id="mobile-menu" class="md:hidden hidden overflow-hidden transition-all duration-300">
                <div class="px-6 pb-6 flex flex-col gap-4 border-t border-sky-100 pt-4">
                    <a href="/" class="text-slate-800 font-bold text-xl py-2 border-b border-sky-50 hover:text-blue-600 transition-colors">{{ __('الرئيسية') }}</a>
                    <a href="/courses" class="text-slate-700 font-bold text-xl py-2 border-b border-sky-50 hover:text-blue-600 transition-colors">{{ __('كورساتنا') }}</a>
                    <a href="/#about" class="text-slate-700 font-bold text-xl py-2 border-b border-sky-50 hover:text-blue-600 transition-colors">{{ __('من نحن') }}</a>
                    @if(app()->getLocale() == 'ar')
                        <a href="/lang/en" class="text-slate-700 font-bold text-xl py-2 border-b border-sky-50 hover:text-blue-600 transition-colors">English</a>
                    @else
                        <a href="/lang/ar" class="text-slate-700 font-bold text-xl py-2 border-b border-sky-50 hover:text-blue-600 transition-colors">عربي</a>
                    @endif
                    <button onclick="document.getElementById('trial-modal').classList.remove('hidden'); document.getElementById('trial-modal').classList.add('flex'); toggleMobileMenu();" class="mt-2 bg-pink-500 hover:bg-pink-600 text-white font-extrabold px-6 py-3 rounded-full shadow-md text-center transition-colors text-base">
                        {{ __('حصة تجريبية مجانية') }} 🚀
                    </button>
                    <a href="/contact" class="bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold px-6 py-3 rounded-full shadow-md text-center transition-colors text-base">
                        {{ __('تواصل معنا') }}
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const bar1 = document.getElementById('bar1');
            const bar2 = document.getElementById('bar2');
            const bar3 = document.getElementById('bar3');
            const isOpen = !menu.classList.contains('hidden');

            if (isOpen) {
                menu.classList.add('hidden');
                bar1.style.transform = '';
                bar2.style.opacity = '1';
                bar3.style.transform = '';
            } else {
                menu.classList.remove('hidden');
                bar1.style.transform = 'translateY(8px) rotate(45deg)';
                bar2.style.opacity = '0';
                bar3.style.transform = 'translateY(-8px) rotate(-45deg)';
            }
        }

        // Close menu when clicking a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
                document.getElementById('bar1').style.transform = '';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('bar3').style.transform = '';
            });
        });
    </script>


    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-slate-800 border-t border-sky-100 py-12 relative overflow-hidden">
        <!-- Floating elements in footer -->
        <div class="absolute top-0 right-10 w-20 h-20 bg-primary/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-10 left-10 w-32 h-32 bg-accent/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2 space-y-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <div class="flex items-center gap-2 {{ app()->getLocale() == 'ar' ? 'justify-start' : 'justify-start' }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10">
                        <span class="text-2xl font-black text-blue-600">A+ Academy</span>
                    </div>
                    <p class="text-slate-700 font-bold leading-relaxed text-base">
                        {{ __('نهدف إلى إطلاق العنان لإبداع الأطفال وتعزيز مهاراتهم في البرمجة وفهم أساسياتها عن طريق التعليم عن بعد.') }}
                    </p>
                    <div class="flex gap-4 {{ app()->getLocale() == 'ar' ? 'justify-start' : 'justify-start' }}">
                        @if($academyInfo?->facebook_url)
                            <a href="{{ $academyInfo->facebook_url }}" target="_blank" class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                            </a>
                        @endif
                        @if($academyInfo?->instagram_url)
                            <a href="{{ $academyInfo->instagram_url }}" target="_blank" class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-pink-600 hover:bg-pink-600 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                            </a>
                        @endif
                        @if($academyInfo?->tiktok_url)
                            <a href="{{ $academyInfo->tiktok_url }}" target="_blank" class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-slate-800 hover:bg-black hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25v178.72A162.55 162.55 0 1 1 162.6 182.2v81.18a81.28 81.28 0 1 0 81.27 81.28V0h81.27a192.4 192.4 0 0 0 122.86 44.4z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h3 class="font-black text-xl mb-4 text-blue-700">{{ __('روابط مهمة') }}</h3>
                    <ul class="space-y-3 text-slate-700 text-base font-bold">
                        <li><a href="/" class="hover:text-blue-600 transition-colors">{{ __('الرئيسية') }}</a></li>
                        <li><a href="/courses" class="hover:text-blue-600 transition-colors">{{ __('كورساتنا') }}</a></li>
                        <li><a href="/about" class="hover:text-blue-600 transition-colors">{{ __('من نحن') }}</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-black text-xl mb-4 text-blue-700">{{ __('تواصل معنا بسرعة') }}</h3>
                    <ul class="space-y-3 text-slate-700 text-base font-bold">
                        <li class="flex items-center gap-2">
                            <span class="text-lg">📞</span> {{ $academyInfo?->phone ?? '01012345678' }}
                        </li>
                        @if($academyInfo?->phone2)
                        <li class="flex items-center gap-2">
                            <span class="text-lg">📞</span> {{ $academyInfo->phone2 }}
                        </li>
                        @endif
                        @if($academyInfo?->whatsapp_phone)
                        <li class="flex items-center gap-2">
                            <span class="text-green-600 text-lg">
                                <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157.1zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                            </span> 
                            {{ $academyInfo->whatsapp_phone }}
                        </li>
                        @endif
                        <li class="flex items-center gap-2">
                            <span class="text-lg">✉️</span> {{ $academyInfo?->email ?? 'info@aacademy.site' }}
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-sky-100 mt-12 pt-8 text-center text-slate-700 font-bold text-base flex flex-col md:flex-row justify-center items-center gap-2">
                &copy; {{ date('Y') }} A+ Academy. {{ __('جميع الحقوق محفوظة') }}
                <span class="hidden md:inline mx-2 text-slate-300">|</span>
                <span class="font-extrabold text-blue-700 text-lg">Engineer Mahmoud Saad</span>
            </div>
        </div>
    </footer>

    <!-- Funny Floating WhatsApp Button -->
    <div class="fixed bottom-6 left-6 z-[100]">
        <div class="relative group">
            <!-- Tooltip Message -->
            <div class="absolute bottom-full left-0 mb-4 bg-green-600 px-4 py-2 rounded-2xl rounded-bl-none shadow-xl border-2 border-green-700 text-sm font-bold text-white whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform origin-bottom-left group-hover:-translate-y-2 pointer-events-none">
                {{ __('احجز حصتك التجريبية مجاناً! 🚀') }}
                <div class="absolute -bottom-2 left-0 w-3 h-3 bg-green-600 border-b-2 border-r-2 border-green-700 transform rotate-45 translate-x-4"></div>
            </div>
            
            <!-- WhatsApp Button -->
            <a href="https://wa.me/{{ $academyInfo?->formatted_whatsapp_phone ?? '201012345678' }}?text=مرحباً، أريد حجز حصة تجريبية لطفلي في الأكاديمية!" target="_blank" class="w-16 h-16 bg-green-500 text-white rounded-[2rem] rounded-bl-xl shadow-lg shadow-green-500/40 flex items-center justify-center hover:bg-green-600 transition-colors animate-wiggle group-hover:animate-none">
                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 448 512">
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157.1zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                </svg>
            </a>
            
            <!-- Pulse ring -->
            <div class="absolute inset-0 bg-green-500 rounded-[2rem] rounded-bl-xl z-[-1] animate-ping opacity-30"></div>
        </div>
    </div>

    <!-- Free Trial Booking Modal (Global) -->
    <div id="trial-modal" class="fixed inset-0 z-[100] hidden items-center justify-center">
        <div class="absolute inset-0 bg-slate-800/60 backdrop-blur-sm" onclick="document.getElementById('trial-modal').classList.add('hidden'); document.getElementById('trial-modal').classList.remove('flex');"></div>
        <div class="bg-white rounded-[2rem] p-8 md:p-10 max-w-lg w-full relative z-10 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} m-4 transform transition-all border-4 border-yellow-400 shadow-2xl">
            <button onclick="document.getElementById('trial-modal').classList.add('hidden'); document.getElementById('trial-modal').classList.remove('flex');" class="absolute top-4 {{ app()->getLocale() == 'ar' ? 'left-4' : 'right-4' }} text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="text-center mb-6">
                <span class="text-5xl block mb-2">🚀</span>
                <h4 class="text-3xl font-black text-blue-900">{{ __('حجز حصة تجريبية مجانية') }}</h4>
                <p class="text-slate-600 font-bold text-sm mt-1">{{ __('سجل بيانات بطلكم الصغير لتأكيد موعده معنا') }}</p>
            </div>
            
            <form action="/book-trial" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-black text-slate-800 mb-2">{{ __('اسم الطفل') }}</label>
                    <input type="text" name="student_name" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} font-bold text-slate-800 text-sm" placeholder="{{ __('الاسم ثلاثي') }}">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-black text-slate-800 mb-2">{{ __('عمر الطفل') }}</label>
                        <input type="number" name="age" min="3" max="18" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} font-bold text-slate-800 text-sm" placeholder="{{ __('مثال: 8') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-slate-800 mb-2">{{ __('تاريخ الجلسة المفضل') }}</label>
                        <input type="date" name="session_date" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} font-bold text-slate-800 text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-slate-800 mb-2">{{ __('رقم هاتف ولي الأمر (واتساب)') }}</label>
                    <input type="tel" name="parent_phone" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} font-bold text-slate-800 text-sm" placeholder="01xxxxxxxxx">
                </div>
                
                <div>
                    <label class="block text-sm font-black text-slate-800 mb-2">{{ __('ملاحظات إضافية (اختياري)') }}</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} font-bold text-slate-800 text-sm" placeholder="{{ __('أي ألعاب يفضلها أو مهارات سابقة...') }}"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-extrabold py-4 rounded-2xl shadow-lg shadow-blue-600/30 transition-all text-lg flex items-center justify-center gap-2">
                    {{ __('احجز الجلسة الآن وانتقل للواتساب') }} 🎯

                </button>
            </form>
        </div>
    </div>

    @stack('scripts')
    </div>
</body>
</html>
