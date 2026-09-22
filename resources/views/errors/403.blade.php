<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak | Bimbel Pelita Ilmu</title>
    <link rel="icon" href="{{ asset('images/logo-bimbel-removebg.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Decorative background glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-lg w-full text-center bg-slate-900/80 backdrop-blur-xl border border-slate-800 p-8 sm:p-12 rounded-3xl shadow-2xl">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo-bimbel-removebg.png') }}" alt="Pelita Ilmu" class="h-16 w-auto drop-shadow-md">
        </div>

        <h1 class="text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-amber-400 tracking-tight">403</h1>
        <h2 class="mt-3 text-xl sm:text-2xl font-bold text-slate-100">Akses Dibatasi</h2>
        <p class="mt-3 text-slate-400 text-sm sm:text-base leading-relaxed">
            Maaf, akun Anda tidak memiliki hak akses untuk membuka halaman ini. Silakan hubungi Administrator Bimbel Pelita Ilmu jika Anda memerlukan bantuan.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="/admin" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-lg shadow-amber-400/20">
                Kembali ke Dashboard
            </a>
            <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 transition-colors border border-slate-700">
                Beranda Utama
            </a>
        </div>
    </div>
</body>
</html>
