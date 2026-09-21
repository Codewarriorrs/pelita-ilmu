<<<<<<< HEAD
<footer id="kontak" class="bg-[#193836] text-white border-t border-stone-700">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12 items-start">
            <div class="md:col-span-5 flex items-start gap-4">
                <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-16 w-16 shrink-0 object-contain drop-shadow" onerror="this.src='{{ asset('images/logo-bimbel.png') }}'">
                <div class="space-y-1">
                    <h2 class="font-headline text-xl font-bold text-white">Pelita Ilmu</h2>
=======
<footer id="kontak" class="bg-primary text-canvas border-t border-canvas/15">
    {{-- Container Utama (Diselaraskan dengan max-w-7xl seperti Hero & Keunggulan) --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-12 lg:gap-12 items-start">
            
            {{-- Kolom 1: Logo & Alamat (Lebar 5 Kolom) --}}
            <div class="md:col-span-5 flex items-start gap-4 sm:gap-5">
                <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-20 w-20 sm:h-24 sm:w-24 shrink-0 object-contain">
                <div class="space-y-2">
                    <h2 class="font-headline font-bold text-xl sm:text-2xl text-canvas">Pelita Ilmu</h2>
>>>>>>> f7c3637e37fcfac5ad8c1efa09696db0d95f612b
                    <p class="font-subtitle text-xs text-highlight font-bold tracking-wide uppercase">Bimbingan Belajar</p>
                    <p class="font-body text-xs text-white/85 leading-relaxed mt-1">
                        <a href="https://maps.app.goo.gl/4mZR8LgBXbN69YL4A" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors">
                            Jl. Rorojonggrang XV No. 6 RT 05 RW 10 Manyaran, Semarang Barat.
                        </a>
                    </p>
                </div>
            </div>
<<<<<<< HEAD
            <div class="md:col-span-4 space-y-2">
                <h3 class="font-subtitle text-sm font-bold text-white uppercase tracking-wider">Hubungi Kami</h3>
                <ul class="space-y-1 font-body text-xs text-white/85">
=======

            {{-- Kolom 2: Kontak Langsung (Lebar 4 Kolom) --}}
            <div class="md:col-span-4 space-y-3">
                <h3 class="font-headline text-base sm:text-lg font-bold text-canvas flex items-center gap-2">
                    <span>Hubungi Kami</span>
                </h3>
                <ul class="space-y-2.5 font-body text-sm">
>>>>>>> f7c3637e37fcfac5ad8c1efa09696db0d95f612b
                    <li>
                        <a href="https://wa.me/6289624601717" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-1.5">
                            <strong class="font-bold">089 624 601 717</strong> <span class="text-white/70 text-[11px]">(Admin)</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/6285866455553" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-1.5">
                            <strong class="font-bold">085 866 455 553</strong> <span class="text-white/70 text-[11px]">(Lita)</span>
                        </a>
                    </li>
                </ul>
            </div>
<<<<<<< HEAD
            <div class="md:col-span-3 space-y-2">
                <h3 class="font-subtitle text-sm font-bold text-white uppercase tracking-wider">Media Sosial</h3>
                <ul class="space-y-1 font-body text-xs text-white/85">
=======

            {{-- Kolom 3: Sosial Media (Lebar 3 Kolom) --}}
            <div class="md:col-span-3 space-y-3">
                <h3 class="font-headline text-base sm:text-lg font-bold text-canvas flex items-center gap-2">
                    <span>Media Sosial</span>
                </h3>
                <ul class="space-y-2.5 font-body text-sm">
>>>>>>> f7c3637e37fcfac5ad8c1efa09696db0d95f612b
                    <li>
                        <a href="https://www.instagram.com/bimbelpelitailmu" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors">
                            Instagram: <strong>@bimbelpelitailmu</strong>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@bimbelpelitailmu" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors">
                            TikTok: <strong>@bimbelpelitailmu</strong>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="border-t border-stone-700 py-4 text-center text-xs text-white/75 font-body">
        &copy; {{ date('Y') }} 
        <button type="button" onclick="triggerEasterEgg()" class="text-white hover:text-highlight font-bold transition-all inline-flex items-center gap-1 group focus:outline-none" title="Klik untuk kejutan Easter Egg! 💡">
            <span>Pelita Ilmu Bimbel</span>
            <span class="text-highlight group-hover:scale-125 transition-transform inline-block">💡✨</span>
        </button>. Semua hak dilindungi.
    </div>
</footer>