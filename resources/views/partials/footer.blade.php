<footer id="kontak" class="bg-primary text-canvas border-t border-canvas/15">
    {{-- Container Utama (Diselaraskan dengan max-w-7xl seperti Hero & Keunggulan) --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-12 lg:gap-12 items-start">
            
            {{-- Kolom 1: Logo & Alamat (Lebar 5 Kolom) --}}
            <div class="md:col-span-5 flex items-start gap-4 sm:gap-5">
                <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Logo Pelita Ilmu" class="h-20 w-20 sm:h-24 sm:w-24 shrink-0 object-contain">
                <div class="space-y-2">
                    <h2 class="font-headline font-bold text-xl sm:text-2xl text-canvas">Pelita Ilmu</h2>
                    <p class="font-subtitle text-xs text-highlight font-bold tracking-wide uppercase">Bimbingan Belajar</p>
                    <p class="text-sm text-canvas/85 leading-relaxed max-w-sm font-body">
                        <a href="https://maps.app.goo.gl/4mZR8LgBXbN69YL4A" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-2">Jl. Rorojonggrang XV No. 6 RT 05 RW 10 Manyaran, Semarang Barat. </a>
                    </p>
                </div>
            </div>

            {{-- Kolom 2: Kontak Langsung (Lebar 4 Kolom) --}}
            <div class="md:col-span-4 space-y-3">
                <h3 class="font-headline text-base sm:text-lg font-bold text-canvas flex items-center gap-2">
                    <span>Hubungi Kami</span>
                </h3>
                <ul class="space-y-2.5 font-body text-sm">
                    <li>
                        <a href="https://wa.me/6289624601717" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-2">
                            <span class="font-bold">089 624 601 717</span>
                            <span class="text-canvas/80 text-xs">(Admin)</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/6285866455553" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-2">
                            <span class="font-bold">085 866 455 553</span>
                            <span class="text-canvas/80 text-xs">(Lita)</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Sosial Media (Lebar 3 Kolom) --}}
            <div class="md:col-span-3 space-y-3">
                <h3 class="font-headline text-base sm:text-lg font-bold text-canvas flex items-center gap-2">
                    <span>Media Sosial</span>
                </h3>
                <ul class="space-y-2.5 font-body text-sm">
                    <li>
                        <a href="https://www.instagram.com/bimbelpelitailmu" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-2">
                            <span>Instagram</span>
                            <span class="text-canvas/70 text-xs">@bimbelpelitailmu</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@bimbelpelitailmu" target="_blank" rel="noopener noreferrer" class="hover:text-highlight transition-colors inline-flex items-center gap-2">
                            <span>TikTok</span>
                            <span class="text-canvas/70 text-xs">@bimbelpelitailmu</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Garis Copyright Bawah --}}
    <div class="border-t border-canvas/15">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-5 text-center text-xs text-canvas/75 font-body">
            &copy; {{ date('Y') }} <span class="font-bold text-canvas">Pelita Ilmu Bimbel</span>. Semua hak dilindungi.
        </div>
    </div>
</footer>
