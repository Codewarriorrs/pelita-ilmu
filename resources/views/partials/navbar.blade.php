<header class="fixed top-0 left-0 right-0 z-50 h-20 bg-canvas border-b border-primary-2/15">
    <nav class="mx-auto flex h-full max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Navigasi utama">
        <a href="{{ route('beranda') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-15 w-15 object-contain">
            <div class="flex flex-col">
                <span class="font-headline text-xl text-primary">
                    Pelita Ilmu 
                </span>
                <span class="font-subtitle text-sm text-primary-2">
                    Bimbingan Belajar
                </span>
            </div>
        </a>

        <button
            type="button"
            id="nav-toggle"
            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-primary-2/20 text-primary-2 lg:hidden"
            aria-controls="nav-menu"
            aria-expanded="false"
            aria-label="Buka menu"
        >
            <span class="sr-only">Menu</span>
            <svg id="icon-open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
            <svg id="icon-close" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>

        <div
            id="nav-menu"
            class="absolute left-0 right-0 top-20 hidden flex-col gap-1 border-b border-primary-2/15 bg-canvas px-4 py-4 lg:static lg:flex lg:flex-row lg:items-center lg:gap-6 lg:border-0 lg:p-0"
        >
            <a href="{{ url('/#beranda') }}" class="rounded-lg px-3 py-2 font-subtitle text-sm text-void hover:text-primary">Beranda</a>
            <a href="{{ url('/#program') }}" class="rounded-lg px-3 py-2 font-subtitle text-sm text-void hover:text-primary">Program</a>
            <a href="{{ url('/daftar') }}" class="rounded-lg px-3 py-2 font-subtitle text-sm text-void hover:text-primary">Pendaftaran</a>
            <a href="{{ url('/#kontak') }}" class="rounded-lg px-3 py-2 font-subtitle text-sm text-void hover:text-primary">Kontak</a>
            <a
                href="{{ route('pendaftaran') }}"
                class="mt-2 inline-flex items-center justify-center rounded-xl bg-highlight px-4 py-2.5 font-subtitle text-sm font-bold text-void lg:mt-0 hover:translate-y-0.5 transition-all shadow-sm"
            >
                Daftar Bimbel Sekarang ➜
            </a>
        </div>
    </nav>
</header>
