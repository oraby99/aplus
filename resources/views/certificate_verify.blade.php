<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شهادة إتمام الكورس | A+ Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <style>
        body { font-family: 'Tajawal', sans-serif; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); }

        .certificate-border {
            border: 15px solid #2563eb;
            outline: 5px solid #fde047;
            outline-offset: -10px;
        }
        #qrcode canvas, #qrcode img { margin: auto; border-radius: 8px; }

        /* ===== CELEBRATION OVERLAY ===== */
        #celebration-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, rgba(37,99,235,0.97) 0%, rgba(109,40,217,0.97) 100%);
            animation: overlayFadeOut 0.6s ease-in 3s forwards;
        }
        #celebration-overlay.hidden { display: none; }

        @keyframes overlayFadeOut {
            0%   { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(1.05); pointer-events: none; visibility: hidden; }
        }

        .mabrook-text {
            font-size: clamp(3rem, 12vw, 7rem);
            font-weight: 900;
            color: #fff;
            text-shadow: 0 0 40px rgba(253,224,71,0.8), 0 4px 20px rgba(0,0,0,0.4);
            animation: mabrookPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
            letter-spacing: -2px;
        }
        @keyframes mabrookPop {
            0%   { transform: scale(0) rotate(-10deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }

        .mabrook-emoji {
            font-size: clamp(3rem, 10vw, 5rem);
            animation: emojiBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.8s both;
        }
        @keyframes emojiBounce {
            0%   { transform: translateY(-60px) scale(0); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        .mabrook-name {
            font-size: clamp(1.2rem, 4vw, 2rem);
            font-weight: 700;
            color: #fde047;
            text-shadow: 0 2px 12px rgba(0,0,0,0.3);
            animation: nameFadeIn 0.5s ease 1.2s both;
            margin-top: 0.5rem;
        }
        @keyframes nameFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stars-row {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
            animation: starsIn 0.5s ease 1.6s both;
        }
        @keyframes starsIn {
            from { opacity: 0; transform: scale(0.5); }
            to   { opacity: 1; transform: scale(1); }
        }
        .star-item {
            font-size: 2rem;
            animation: starSpin 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        .star-item:nth-child(1) { animation-delay: 1.6s; }
        .star-item:nth-child(2) { animation-delay: 1.75s; }
        .star-item:nth-child(3) { animation-delay: 1.9s; }
        .star-item:nth-child(4) { animation-delay: 2.05s; }
        .star-item:nth-child(5) { animation-delay: 2.2s; }
        @keyframes starSpin {
            0%   { transform: rotate(-180deg) scale(0); opacity: 0; }
            100% { transform: rotate(0deg) scale(1); opacity: 1; }
        }

        /* Certificate entrance */
        #cert-wrapper {
            animation: certEntrance 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 3.4s both;
        }
        @keyframes certEntrance {
            0%   { transform: translateY(40px) scale(0.95); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        @media print {
            body { background: none !important; padding: 0 !important; }
            .no-print { display: none !important; }
            #celebration-overlay { display: none !important; }
            .certificate-border { border-width: 10px !important; outline-width: 3px !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 md:p-8">

    <!-- ===== CELEBRATION OVERLAY ===== -->
    <div id="celebration-overlay">
        <div class="mabrook-emoji">🏆</div>
        <div class="mabrook-text">مبروك! 🎉</div>
        <div class="mabrook-name">{{ $certificate->student->name }}</div>
        <div class="stars-row">
            <span class="star-item">⭐</span>
            <span class="star-item">🌟</span>
            <span class="star-item">✨</span>
            <span class="star-item">🌟</span>
            <span class="star-item">⭐</span>
        </div>
    </div>

    <!-- Actions (No Print) -->
    <div id="cert-wrapper" class="w-full max-w-4xl">
        <div class="mb-6 flex justify-between items-center no-print">
            <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow transition-all">
                ← العودة للرئيسية
            </a>
            <button onclick="window.print()" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-extrabold px-8 py-2.5 rounded-xl shadow-lg shadow-yellow-500/20 transition-all flex items-center gap-2">
                🖨️ طباعة الشهادة
            </button>
        </div>

        <!-- Premium Kids Certificate -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 relative certificate-border overflow-hidden text-center">

            <!-- Stars & Background Decorations -->
            <div class="absolute top-10 left-10 text-5xl opacity-20">⭐</div>
            <div class="absolute top-10 right-10 text-5xl opacity-20">⭐</div>
            <div class="absolute bottom-10 left-10 text-5xl opacity-20">✨</div>
            <div class="absolute bottom-10 right-10 text-5xl opacity-20">✨</div>

            <div class="relative z-10 flex flex-col items-center">

                <!-- Academy Logo & Title -->
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16" onerror="this.src='https://aplusacademy.courses/images/logo.png'">
                    <div class="text-right">
                        <h2 class="text-3xl font-black text-blue-600">A+ Academy</h2>
                        <span class="text-xs font-bold text-slate-400 block tracking-wider">BUILD YOUR FUTURE</span>
                    </div>
                </div>

                <!-- Certificate Header -->
                <h1 class="text-4xl md:text-5xl font-black text-slate-800 mb-8" style="text-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    شهادة إتمام كورس 🎓
                </h1>

                <p class="text-lg md:text-xl text-slate-500 font-bold mb-6">
                    فخورون بتقديم هذه الشهادة بكل اعتزاز إلى البطل المبرمج:
                </p>

                <!-- Student Name -->
                <div class="bg-blue-50/50 border-y-2 border-dashed border-blue-200 py-4 px-12 rounded-2xl mb-8">
                    <h2 class="text-3xl md:text-5xl font-black text-blue-900">{{ $certificate->student->name }}</h2>
                </div>

                <!-- Achievement Text -->
                <p class="text-lg md:text-xl text-slate-700 leading-loose max-w-2xl font-bold mb-10">
                    لاشتراكه وتميزه في إتمام كورس <span class="text-blue-600 font-extrabold text-2xl">{{ $certificate->course->title }}</span> بنجاح،
                    وتعلم المفاهيم الأساسية وتطوير مشاريعه الخاصة بكفاءة وإبداع.
                </p>

                <!-- Gold Medal Seal -->
                <div class="relative w-28 h-28 bg-gradient-to-tr from-yellow-400 to-yellow-300 rounded-full border-4 border-white shadow-lg flex items-center justify-center flex-col z-10 mb-8 animate-pulse">
                    <div class="absolute inset-2 border-2 border-dashed border-yellow-600 rounded-full"></div>
                    <span class="text-4xl">🎖️</span>
                    <span class="text-[10px] font-black text-yellow-800 tracking-wider">A+ ACADEMY</span>
                </div>

                <!-- Footer: Serial + QR + Date -->
                <div class="w-full grid grid-cols-3 gap-6 border-t border-slate-100 pt-8 items-center">
                    <div class="text-right">
                        <p class="text-xs text-slate-400 font-bold mb-1">الرقم التسلسلي للشهادة:</p>
                        <p class="text-sm font-bold text-blue-600 font-mono">{{ $certificate->serial_number }}</p>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <div id="qrcode"></div>
                        <p class="text-[10px] text-slate-400 font-bold">امسح للتحقق من الشهادة</p>
                    </div>

                    <div class="text-left">
                        <p class="text-xs text-slate-400 font-bold mb-1">تاريخ الإصدار:</p>
                        <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($certificate->issue_date)->format('Y-m-d') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // ===== QR CODE =====
        document.addEventListener('DOMContentLoaded', function () {
            new QRCode(document.getElementById("qrcode"), {
                text: "{{ url('/certificate/' . $certificate->serial_number) }}",
                width: 100,
                height: 100,
                colorDark: "#1e3a8a",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            // ===== CELEBRATION CONFETTI =====
            const overlay = document.getElementById('celebration-overlay');

            // First burst right away
            fireConfetti();

            // Keep shooting during overlay
            const confettiInterval = setInterval(fireConfetti, 700);

            // Remove overlay after animation ends (3s fade + 0.6s animation)
            setTimeout(() => {
                overlay.style.display = 'none';
                clearInterval(confettiInterval);
                // Final big burst after overlay closes
                fireBigConfetti();
            }, 3700);
        });

        function fireConfetti() {
            confetti({
                particleCount: 80,
                spread: 100,
                origin: { y: 0.3 },
                colors: ['#2563eb', '#fde047', '#f97316', '#10b981', '#ec4899', '#8b5cf6'],
                shapes: ['star', 'circle'],
                scalar: 1.2,
                zIndex: 10000,
            });
        }

        function fireBigConfetti() {
            // Left side
            confetti({ particleCount: 120, angle: 60, spread: 80, origin: { x: 0 }, colors: ['#2563eb','#fde047','#10b981','#ec4899'] });
            // Right side
            setTimeout(() => {
                confetti({ particleCount: 120, angle: 120, spread: 80, origin: { x: 1 }, colors: ['#f97316','#8b5cf6','#fde047','#2563eb'] });
            }, 200);
            // Center top burst
            setTimeout(() => {
                confetti({ particleCount: 150, spread: 130, origin: { y: 0.4 }, shapes: ['star'], scalar: 1.5, colors: ['#fde047','#f97316','#ec4899','#10b981'] });
            }, 400);
        }
    </script>

</body>
</html>
