<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas & Tentor — Bimbel Pelita Ilmu</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Script -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            700: '#0F766E',
                            800: '#115E59',
                            900: '#134E4A',
                        },
                        yellow: {
                            brand: '#FFE500',
                            brandDark: '#F5D000',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F7F9F9] min-h-screen flex items-center justify-center p-4 antialiased text-stone-800">

    <div class="max-w-md w-full">
        
        <!-- Brand Logo & Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl bg-teal-900 border-2 border-teal-700 p-1 flex items-center justify-center text-center shadow-sm">
                    <span class="text-[10px] font-black text-yellow-brand leading-none">Pelita<br><span class="text-white text-[9px]">Ilmu</span></span>
                </div>
                <div class="text-left">
                    <span class="block text-2xl font-extrabold text-stone-900 tracking-tight leading-none">Pelita Ilmu</span>
                    <span class="block text-[11px] font-bold text-teal-700 tracking-wider uppercase mt-1">Sistem Manajemen Bimbel</span>
                </div>
            </a>
            <h1 class="text-xl font-bold text-stone-900 mt-6">Masuk ke Portal Admin</h1>
            <p class="text-xs text-stone-500 mt-1">Silakan masuk menggunakan akun Administrator atau Tentor</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl p-8 border border-stone-200 shadow-sm">
            
            @if (session('error'))
                <div class="mb-5 p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="admin@pelitailmu.id" 
                        class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 bg-red-50/40 @else border-stone-300 @enderror focus:border-teal-700 focus:outline-none focus:ring-1 focus:ring-teal-700 text-sm shadow-sm transition-all"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="••••••••" 
                        class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 bg-red-50/40 @else border-stone-300 @enderror focus:border-teal-700 focus:outline-none focus:ring-1 focus:ring-teal-700 text-sm shadow-sm transition-all"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-teal-700 border-stone-300 focus:ring-teal-700">
                        <span class="text-xs text-stone-600 font-medium">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 rounded-xl bg-yellow-brand hover:bg-yellow-brandDark text-stone-950 font-bold text-sm shadow-sm hover:shadow transition-all"
                >
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-stone-100 text-center">
                <a href="/" class="text-xs font-semibold text-teal-700 hover:text-teal-900 transition-colors">
                    ← Kembali ke Halaman Utama
                </a>
            </div>
        </div>

    </div>

</body>
</html>
