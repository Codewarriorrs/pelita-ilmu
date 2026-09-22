<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>@yield('title', 'Pelita Ilmu Bimbel')</title>
        
        <!-- Google Fonts: Fredoka, Instrument Sans, Nunito, Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Tailwind CSS & Custom Config -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#009688',
                            'primary-dark': '#00796B',
                            'primary-2': '#193836',
                            highlight: '#FFE500',
                            'highlight-dark': '#F5D000',
                            canvas: '#F8FAFC',
                            void: '#1E293B',
                        },
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                            headline: ['Fredoka', 'sans-serif'],
                            heading: ['Fredoka', 'sans-serif'],
                            subtitle: ['Nunito', 'sans-serif'],
                            body: ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <!-- Alpine.js CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #F8FAFC;
                color: #1E293B;
            }

            .font-headline, .font-heading { font-family: 'Fredoka', sans-serif; }
            .font-subtitle { font-family: 'Nunito', sans-serif; font-weight: 700; }
            .font-body     { font-family: 'Poppins', sans-serif; }

            /* Keyframe Animations */
            @keyframes bd-dot-wave {
                0%, 70%, 100% { opacity: 0.35; transform: scale(0.85); }
                35% { opacity: 1; transform: scale(1.1); }
            }
            .bd-dot {
                transform-box: fill-box;
                transform-origin: center;
                animation: bd-dot-wave 1.4s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            .animate-float { animation: float 3s ease-in-out infinite; }

            .bubble-bg {
                background-image: radial-gradient(circle at 20% 20%, rgba(255, 229, 0, 0.15) 0%, transparent 40%),
                                  radial-gradient(circle at 80% 80%, rgba(0, 150, 136, 0.2) 0%, transparent 50%);
            }

            #navbar-cta {
                opacity: 0;
                transform: translateY(-6px) scale(0.97);
                pointer-events: none;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            #navbar-cta.cta-visible {
                opacity: 1;
                transform: translateY(0) scale(1);
                pointer-events: auto;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-canvas text-void min-h-screen flex flex-col antialiased selection:bg-primary selection:text-white pb-20 md:pb-0">

        @unless (View::hasSection('hide_navbar'))
            @include('partials.navbar')
        @endunless

        <main class="flex-1 @unless (View::hasSection('hide_navbar')) pt-20 @endunless">
            @yield('content')
        </main>

        @include('partials.footer')

        <!-- MOBILE FLOATING BOTTOM NAVBAR (Neo-Brutalist Anti-Metallic Theme) -->
        @php
            $navActive = match(true) {
                request()->routeIs('pendaftaran') => 2,
                request()->routeIs('home') && request()->is('/') => 0,
                default => 0,
            };
        @endphp
        <div class="fixed inset-x-0 bottom-4 z-40 mx-auto w-[94vw] max-w-sm h-14 bg-[#193836] border-2 border-black rounded-full shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center justify-around px-2 md:hidden">
            <!-- Item 1: Beranda -->
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all duration-300 {{ $navActive === 0 ? 'bg-highlight text-void font-bold border border-black shadow-sm' : 'text-white/80 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                @if($navActive === 0)
                    <span class="text-xs font-headline font-extrabold whitespace-nowrap">Home</span>
                @endif
            </a>

            <!-- Item 2: Program -->
            <a href="{{ route('home') }}#program" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all duration-300 {{ $navActive === 1 ? 'bg-highlight text-void font-bold border border-black shadow-sm' : 'text-white/80 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                @if($navActive === 1)
                    <span class="text-xs font-headline font-extrabold whitespace-nowrap">Program</span>
                @endif
            </a>

            <!-- Item 3: Pendaftaran -->
            <a href="{{ route('pendaftaran') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all duration-300 {{ $navActive === 2 ? 'bg-highlight text-void font-bold border border-black shadow-sm' : 'text-white/80 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                @if($navActive === 2)
                    <span class="text-xs font-headline font-extrabold whitespace-nowrap">Daftar</span>
                @endif
            </a>

            <!-- Item 4: Kontak WhatsApp -->
            <a href="https://wa.me/6289624601717?text=Halo%20Admin%20Pelita%20Ilmu,%20saya%20ingin%20bertanya%20mengenai%20bimbingan%20belajar" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all duration-300 text-white/80 hover:text-white">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </a>
        </div>

        <!-- EASTER EGG GAME MODAL (Neo-Brutalist Program Card Style + Lightbulb Rocket Dino Game) -->
        <div id="easter-egg-modal" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/70 backdrop-blur-md p-4">
            <div class="relative w-full max-w-lg bg-white border-4 border-black rounded-[32px] p-6 sm:p-8 text-void shadow-[8px_8px_0px_0px_rgba(255,229,0,1)] text-center overflow-hidden">
                
                <!-- Close Button -->
                <button type="button" onclick="closeEasterEgg()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 border-2 border-black flex items-center justify-center text-black font-bold text-sm">
                    ✕
                </button>

                <!-- Header Text -->
                <p class="font-headline font-black text-xs sm:text-sm text-primary uppercase tracking-widest mb-3">
                    🚀 PELITA ROCKET RUNNER 💡
                </p>

                <h3 class="font-headline text-2xl font-black text-[#193836] mb-1">
                    Game Rahasia Pelita Ilmu!
                </h3>
                <p class="font-subtitle text-xs text-void/70 mb-4">
                    Tekan <span class="bg-stone-200 px-2 py-0.5 rounded border border-black font-mono">SPASI</span> atau <span class="bg-stone-200 px-2 py-0.5 rounded border border-black font-mono">TAP KELAS</span> untuk melompati rintangan buku!
                </p>

                <!-- Canvas Game Screen -->
                <div class="relative rounded-2xl overflow-hidden border-2 border-black bg-gradient-to-b from-[#193836] to-primary p-1 mb-4 shadow-inner">
                    <canvas id="rocketGameCanvas" width="440" height="180" class="w-full h-auto cursor-pointer block"></canvas>
                    <div id="gameOverlay" class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 text-white p-4">
                        <span class="font-headline text-xl font-bold text-highlight mb-2">SIAP MELUNCUR?</span>
                        <button type="button" onclick="startRocketGame()" class="px-6 py-2.5 bg-highlight text-void font-headline font-black text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:bg-yellow-400">
                            MULAI MAIN 🚀
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between font-subtitle text-xs font-bold text-[#193836] px-2 mb-4">
                    <span>Skor: <span id="gameScore" class="text-primary font-black">0</span></span>
                    <span>High Score: <span id="gameHighScore" class="text-highlight-dark font-black">0</span></span>
                </div>

                <button type="button" onclick="closeEasterEgg()" class="w-full py-3 bg-[#193836] hover:bg-[#122A28] text-white font-headline font-black rounded-xl text-xs uppercase tracking-wider border-2 border-black shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] transition-all">
                    Tutup Game 🎓
                </button>
            </div>
        </div>

        @livewireScripts

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('nav-menu');
                const iconOpen = document.getElementById('icon-open');
                const iconClose = document.getElementById('icon-close');
                const toggle = document.getElementById('nav-toggle');

                if (menu) {
                    menu.classList.toggle('hidden');
                    const isOpen = !menu.classList.contains('hidden');
                    if (iconOpen) iconOpen.classList.toggle('hidden', isOpen);
                    if (iconClose) iconClose.classList.toggle('hidden', !isOpen);
                    if (toggle) toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                }
            }

            // EASTER EGG & LIGHTBULB ROCKET GAME SCRIPT
            let canvas, ctx;
            let gameRunning = false;
            let animationFrameId;
            let score = 0, highScore = localStorage.getItem('pelita_rocket_highscore') || 0;
            
            const rocket = { x: 40, y: 120, width: 34, height: 34, vy: 0, gravity: 0.6, jumpPower: -10, isGrounded: true };
            let obstacles = [];
            let frameCount = 0;

            function triggerEasterEgg() {
                const modal = document.getElementById('easter-egg-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.getElementById('gameHighScore').innerText = highScore;
                    initCanvas();
                    createConfetti();
                }
            }

            function closeEasterEgg() {
                const modal = document.getElementById('easter-egg-modal');
                if (modal) {
                    modal.classList.add('hidden');
                    gameRunning = false;
                    cancelAnimationFrame(animationFrameId);
                }
            }

            function initCanvas() {
                canvas = document.getElementById('rocketGameCanvas');
                ctx = canvas.getContext('2d');
                drawStaticScene();

                canvas.onclick = function() {
                    if (!gameRunning) startRocketGame();
                    else jump();
                };

                window.onkeydown = function(e) {
                    if (e.code === 'Space' || e.code === 'ArrowUp') {
                        if (!modalIsHidden()) {
                            e.preventDefault();
                            if (!gameRunning) startRocketGame();
                            else jump();
                        }
                    }
                };
            }

            function modalIsHidden() {
                return document.getElementById('easter-egg-modal').classList.contains('hidden');
            }

            function drawStaticScene() {
                ctx.fillStyle = '#193836';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                // Draw Ground
                ctx.fillStyle = '#FFE500';
                ctx.fillRect(0, 155, canvas.width, 25);
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 153, canvas.width, 2);

                // Draw Lightbulb Rocket
                drawRocket(rocket.x, rocket.y);
            }

            function drawRocket(x, y) {
                // Rocket Bulb Head 💡🚀
                ctx.font = '28px sans-serif';
                ctx.fillText('💡', x, y + 24);
                ctx.font = '16px sans-serif';
                ctx.fillText('🔥', x - 12, y + 24);
            }

            function drawObstacle(obs) {
                ctx.font = '24px sans-serif';
                ctx.fillText('📚', obs.x, obs.y + 24);
            }

            function jump() {
                if (rocket.isGrounded) {
                    rocket.vy = rocket.jumpPower;
                    rocket.isGrounded = false;
                }
            }

            function startRocketGame() {
                document.getElementById('gameOverlay').classList.add('hidden');
                gameRunning = true;
                score = 0;
                frameCount = 0;
                obstacles = [];
                rocket.y = 120;
                rocket.vy = 0;
                rocket.isGrounded = true;
                document.getElementById('gameScore').innerText = 0;
                gameLoop();
            }

            function gameLoop() {
                if (!gameRunning) return;

                frameCount++;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawStaticScene();

                // Rocket Physics
                rocket.vy += rocket.gravity;
                rocket.y += rocket.vy;
                if (rocket.y >= 120) {
                    rocket.y = 120;
                    rocket.vy = 0;
                    rocket.isGrounded = true;
                }

                // Spawn Obstacles
                if (frameCount % 90 === 0) {
                    obstacles.push({ x: canvas.width, y: 125, width: 20, height: 24 });
                }

                // Move & Draw Obstacles
                for (let i = 0; i < obstacles.length; i++) {
                    let obs = obstacles[i];
                    obs.x -= 3.5;
                    drawObstacle(obs);

                    // Collision detection
                    if (rocket.x < obs.x + obs.width &&
                        rocket.x + rocket.width > obs.x &&
                        rocket.y < obs.y + obs.height &&
                        rocket.y + rocket.height > obs.y) {
                        gameOver();
                        return;
                    }
                }

                // Remove offscreen
                obstacles = obstacles.filter(obs => obs.x > -30);

                // Score increment
                if (frameCount % 6 === 0) {
                    score++;
                    document.getElementById('gameScore').innerText = score;
                }

                animationFrameId = requestAnimationFrame(gameLoop);
            }

            function gameOver() {
                gameRunning = false;
                cancelAnimationFrame(animationFrameId);

                if (score > highScore) {
                    highScore = score;
                    localStorage.setItem('pelita_rocket_highscore', highScore);
                    document.getElementById('gameHighScore').innerText = highScore;
                }

                document.getElementById('gameOverlay').classList.remove('hidden');
                document.getElementById('gameOverlay').querySelector('span').innerText = 'GAME OVER! SKOR: ' + score;
            }

            function createConfetti() {
                const colors = ['#FFE500', '#009688', '#ffffff', '#FF5722', '#4CAF50'];
                for (let i = 0; i < 40; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'fixed pointer-events-none z-[130] rounded-full';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = Math.random() * 100 + 'vh';
                    confetti.style.width = (Math.random() * 10 + 6) + 'px';
                    confetti.style.height = (Math.random() * 10 + 6) + 'px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.opacity = Math.random();
                    confetti.style.transition = 'all 1.5s ease-out';
                    document.body.appendChild(confetti);

                    setTimeout(() => {
                        confetti.style.transform = `translate(${(Math.random() - 0.5) * 200}px, ${(Math.random() - 0.5) * 200}px) scale(0)`;
                        confetti.style.opacity = '0';
                    }, 50);

                    setTimeout(() => confetti.remove(), 1500);
                }
            }

            (function() {
                const navbarCta = document.getElementById('navbar-cta');
                const heroCta   = document.getElementById('hero-cta');

                if (!navbarCta || !heroCta) return;

                const observer = new IntersectionObserver(
                    ([entry]) => {
                        if (entry.isIntersecting) {
                            navbarCta.classList.remove('cta-visible');
                        } else {
                            navbarCta.classList.add('cta-visible');
                        }
                    },
                    {
                        root: null,
                        threshold: 0,
                        rootMargin: '0px 0px -80px 0px'
                    }
                );

                observer.observe(heroCta);
            })();
        </script>
    </body>
</html>
