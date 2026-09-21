<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'Pelita Ilmu — Bimbingan Belajar & Privat TK, SD, SMP, SMA')</title>
    <meta name="description" content="Solusi bimbingan belajar terpercaya di Manyaran, Semarang untuk jenjang TK, SD, SMP, hingga SMA. Menghadirkan pengajar berpendidikan S1/S2 dengan metode belajar yang aktif, seru, dan berkarakter.">

    <!-- Google Fonts: Plus Jakarta Sans & Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Script -->
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
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        headline: ['Quicksand', 'Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Quicksand', 'Plus Jakarta Sans', 'sans-serif'],
                        subtitle: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
        }

        .font-headline, .font-heading { font-family: 'Quicksand', sans-serif; }
        .font-subtitle { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; }
        .font-body     { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Anti-Metal Dot Wave Animation */
        @keyframes bd-dot-wave {
            0%, 70%, 100% { opacity: 0.35; transform: scale(0.85); }
            35% { opacity: 1; transform: scale(1.1); }
        }
        .bd-dot {
            transform-box: fill-box;
            transform-origin: center;
            animation: bd-dot-wave 1.4s ease-in-out infinite;
        }

        /* Background Pattern Bubble Decor */
        .bubble-bg {
            background-image: radial-gradient(circle at 20% 20%, rgba(255, 229, 0, 0.15) 0%, transparent 40%),
                              radial-gradient(circle at 80% 80%, rgba(0, 150, 136, 0.2) 0%, transparent 50%);
        }

        /* Navbar CTA — hidden by default, slides in after scroll */
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
<body class="bg-canvas text-void min-h-screen flex flex-col antialiased selection:bg-primary selection:text-white">

    @unless (View::hasSection('hide_navbar'))
        @include('partials.navbar')
    @endunless

    <main class="flex-1 @unless (View::hasSection('hide_navbar')) pt-20 @endunless">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- EASTER EGG MODAL -->
    <div id="easter-egg-modal" class="fixed inset-0 z-[120] hidden flex items-center justify-center bg-black/70 backdrop-blur-md p-4">
        <div class="relative w-full max-w-md bg-[#193836] border-4 border-[#FFE500] rounded-3xl p-6 sm:p-8 text-white shadow-2xl text-center overflow-hidden">
            <div class="absolute -top-10 -left-10 w-36 h-36 bg-[#FFE500]/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -right-10 w-36 h-36 bg-[#009688]/40 rounded-full blur-2xl"></div>

            <div class="relative mx-auto mb-4 w-20 h-20 rounded-full bg-highlight text-void flex items-center justify-center border-4 border-black shadow-xl animate-pulse">
                <svg class="w-10 h-10 text-void" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7zm-2 18h4v1a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-1z"/>
                </svg>
            </div>

            <span class="inline-block px-3 py-1 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-3 border border-black shadow-sm">
                🎉 YOU FOUND THE EASTER EGG!
            </span>

            <h3 class="font-headline text-2xl font-extrabold text-highlight mb-2">
                Rahasia Pelita Ilmu 🌟
            </h3>

            <p class="font-body text-xs sm:text-sm text-white/85 leading-relaxed mb-6">
                "Pendidikan adalah senjata paling mematikan di dunia, karena dengan pendidikan Anda dapat mengubah dunia."
                <span class="block text-highlight font-bold mt-2">— Nelson Mandela</span>
            </p>

            <div class="p-3.5 bg-white/10 rounded-2xl border border-white/20 mb-6 font-body text-xs text-white/80 leading-relaxed">
                ⚡ <strong>Tips Sukses Belajar:</strong> Konsistensi 30 menit belajar setiap hari jauh lebih efektif dari belajar semalaman! Tetap semangat meraih mimpi bareng Pelita Ilmu! 🚀
            </div>

            <button type="button" onclick="closeEasterEgg()" class="w-full py-3.5 bg-highlight hover:bg-yellow-400 text-void font-headline font-black rounded-xl text-xs uppercase tracking-wider border-2 border-black shadow-md transition-all">
                Siap Berprestasi! 🎓
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

        function triggerEasterEgg() {
            const modal = document.getElementById('easter-egg-modal');
            if (modal) {
                modal.classList.remove('hidden');
                createConfetti();
            }
        }

        function closeEasterEgg() {
            const modal = document.getElementById('easter-egg-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
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
