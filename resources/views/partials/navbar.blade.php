<!-- HEADER NAVIGATION -->
<header class="fixed top-0 left-0 right-0 z-50 h-20 bg-white border-b border-stone-200 shadow-sm">
    <nav class="mx-auto flex h-full max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Navigasi utama">
<<<<<<< HEAD

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-14 w-14 object-contain" onerror="this.src='{{ asset('images/logo-bimbel.png') }}'">
            <div class="flex flex-col">
                <span class="font-headline text-[22px] text-primary font-black leading-tight">
                    Pelita Ilmu
                </span>
                <span class="font-subtitle text-[10px] text-[#193836] leading-tight">
=======
        <a href="beranda" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-15 w-15 object-contain">
            <div class="flex flex-col">
                <span class="font-headline font-bold text-xl text-primary">
                    Pelita Ilmu 
                </span>
                <span class="font-subtitle font-bold text-sm text-primary-2">
>>>>>>> f7c3637e37fcfac5ad8c1efa09696db0d95f612b
                    Bimbingan Belajar
                </span>
            </div>
        </a>

        <!-- Desktop Links -->
        <div class="hidden lg:flex lg:items-center lg:gap-6 font-subtitle text-sm">
            <a href="{{ route('home') }}" class="px-3 py-2 text-void hover:text-primary font-bold transition-colors">Beranda</a>
            <a href="{{ route('home') }}#program" class="px-3 py-2 text-void hover:text-primary font-bold transition-colors">Program</a>
            <a href="{{ route('pendaftaran') }}" class="px-3 py-2 text-void hover:text-primary font-bold transition-colors">Pendaftaran</a>
            <a href="{{ route('home') }}#kontak" class="px-3 py-2 text-void hover:text-primary font-bold transition-colors">Kontak</a>

            <!-- Anti-Metal CTA Button — hanya muncul setelah scroll melewati hero CTA -->
            <a id="navbar-cta" href="{{ route('pendaftaran') }}" class="group/btn relative inline-flex h-11 min-w-[160px] items-center justify-center overflow-hidden rounded-xl bg-primary active:scale-[0.98] shadow-md whitespace-nowrap">
                <span class="relative z-20 font-headline font-bold text-sm text-white group-hover/btn:text-[#193836] pl-12 pr-5 transition-colors duration-300">DAFTAR SEKARANG</span>
                <span aria-hidden="true" class="absolute bottom-1 left-1 top-1 z-10 flex w-9 items-center justify-center overflow-hidden rounded-lg bg-highlight transition-[width] duration-300 ease-[cubic-bezier(0.65,0,0.35,1)] group-hover/btn:w-[calc(100%-0.5rem)]">
                    <svg width="14" height="16" viewBox="0 0 14 16" class="shrink-0 overflow-visible">
                        <g fill="#193836">
                            <circle cx="2" cy="2" r="1" class="bd-dot" style="animation-delay:0s"/>
                            <circle cx="5" cy="5" r="1" class="bd-dot" style="animation-delay:0.05s"/>
                            <circle cx="8" cy="8" r="1" class="bd-dot" style="animation-delay:0.1s"/>
                            <circle cx="5" cy="11" r="1" class="bd-dot" style="animation-delay:0.15s"/>
                            <circle cx="2" cy="14" r="1" class="bd-dot" style="animation-delay:0.2s"/>
                            <circle cx="6" cy="2" r="1" class="bd-dot" style="animation-delay:0.05s"/>
                            <circle cx="9" cy="5" r="1" class="bd-dot" style="animation-delay:0.1s"/>
                            <circle cx="12" cy="8" r="1" class="bd-dot" style="animation-delay:0.15s"/>
                            <circle cx="9" cy="11" r="1" class="bd-dot" style="animation-delay:0.2s"/>
                            <circle cx="6" cy="14" r="1" class="bd-dot" style="animation-delay:0.25s"/>
                        </g>
                    </svg>
                </span>
            </a>
        </div>

        <!-- Mobile Hamburger Toggle -->
        <button
            type="button"
            id="nav-toggle"
            onclick="toggleMobileMenu()"
            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border-2 border-black bg-white text-void shadow-sm hover:bg-stone-50 transition-all lg:hidden"
            aria-controls="nav-menu"
            aria-expanded="false"
            aria-label="Buka menu"
        >
            <svg id="icon-open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
            <svg id="icon-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
<<<<<<< HEAD
=======

        <div
            id="nav-menu"
            class="absolute left-0 right-0 top-20 hidden flex-col gap-1 border-b border-primary-2/15 bg-canvas px-4 py-4 lg:static lg:flex lg:flex-row lg:items-center lg:gap-6 lg:border-0 lg:p-0"
        >
            <a href="{{ url('/#beranda') }}" class="rounded-lg px-3 py-2 font-body font-medium text-sm text-void hover:text-primary">Beranda</a>
            <a href="{{ url('/#program') }}" class="rounded-lg px-3 py-2 font-body font-medium text-sm text-void hover:text-primary">Program</a>
            <a href="{{ url('/#pendaftaran') }}" class="rounded-lg px-3 py-2 font-body font-medium text-sm text-void hover:text-primary">Pendaftaran</a>
            <a href="{{ url('/#kontak') }}" class="rounded-lg px-3 py-2 font-body font-medium text-sm text-void hover:text-primary">Kontak</a>
            <a
                href="{{ url('/#pendaftaran') }}"
                class="mt-2 inline-flex items-center justify-center rounded-xl bg-highlight px-4 py-2.5 font-subtitle text-sm font-bold text-void lg:mt-0 hover:translate-y-0.5 transition-all shadow-sm"
            >
                Daftar Bimbel Sekarang ➜
            </a>
        </div>
>>>>>>> f7c3637e37fcfac5ad8c1efa09696db0d95f612b
    </nav>
</header>

<!-- Liquid Morph Floating Menu for Mobile -->
<div id="nav-menu" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] lg:hidden hidden">
    <div class="bg-[#193836] text-white rounded-3xl p-6 shadow-2xl border-2 border-highlight w-72 flex flex-col gap-4 text-center">
        <span class="text-xs font-bold text-highlight uppercase tracking-wider block mb-1">Navigasi Pelita Ilmu</span>
        <a href="{{ route('home') }}" onclick="toggleMobileMenu()" class="text-base font-headline font-extrabold text-white hover:text-highlight transition-colors">Beranda</a>
        <a href="{{ route('home') }}#program" onclick="toggleMobileMenu()" class="text-base font-headline font-extrabold text-white hover:text-highlight transition-colors">Program</a>
        <a href="{{ route('pendaftaran') }}" onclick="toggleMobileMenu()" class="text-base font-headline font-extrabold text-highlight">Pendaftaran</a>
        <a href="{{ route('home') }}#kontak" onclick="toggleMobileMenu()" class="text-base font-headline font-extrabold text-white hover:text-highlight transition-colors">Kontak</a>
        <button type="button" onclick="toggleMobileMenu()" class="mt-2 py-2.5 px-4 bg-highlight text-void font-headline font-black rounded-xl text-xs uppercase tracking-wider shadow-sm hover:bg-yellow-400 transition-all">
            Tutup Menu
        </button>
    </div>
</div>
