<?php

return [
    'admin' => [
        [
            'element' => '#onboarding-welcome',
            'title' => 'Selamat Datang di Bimbel Pelita Ilmu! 👋',
            'description' => 'Halo Admin! Mari kami pandu berkeliling untuk mengenal fitur-fitur utama sistem agar pengelolaan bimbel Anda semakin lancar dan mudah.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => '#onboarding-topbar',
            'title' => 'Pencarian & Notifikasi Terpadu 🔔',
            'description' => 'Gunakan kotak pencarian untuk mencari data siswa, dan pantau lonceng notifikasi untuk melihat aktivitas pendaftaran baru serta jadwal sesi hari ini.',
            'side' => 'bottom',
            'align' => 'end',
        ],
        [
            'element' => 'a[href*="/behindpelita/siswas"]',
            'title' => 'Data Siswa & Profil Akademik 👨‍🎓',
            'description' => 'Di sini Anda dapat melihat seluruh murid terdaftar, status keaktifan, catatan khusus, hingga kelompok belajar yang diikuti siswa.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => 'a[href*="/behindpelita/pendaftarans"]',
            'title' => 'Verifikasi Pendaftaran Online 📝',
            'description' => 'Pendaftar baru dari website akan masuk ke menu ini. Anda dapat meninjau nota ringkasan pendaftaran dan langsung menempatkannya ke rombel/kelompok belajar.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => 'a[href*="/behindpelita/jadwal-kelompoks"]',
            'title' => 'Penjadwalan & Sesi Belajar 📅',
            'description' => 'Kelola jadwal belajar mingguan, tentukan ruang kelas tanpa khawatir bentrok, dan buka sesi presensi belajar.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => 'a[href*="/behindpelita/rekap-pembayarans"]',
            'title' => 'Rekap Keuangan & SPP 💰',
            'description' => 'Pantau pemasukan secara harian, bulanan, atau keseluruhan, filter metode pembayaran (Tunai/Transfer/QRIS), dan catat pembayaran siswa.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => '#onboarding-bantuan-btn',
            'title' => 'Butuh Panduan Lagi? 💡',
            'description' => 'Kapan pun Anda butuh panduan ini kembali, cukup klik tombol "Bantuan & Panduan" di bagian bawah menu ini. Selamat bertugas!',
            'side' => 'right',
            'align' => 'end',
        ],
    ],

    'tentor' => [
        [
            'element' => '#onboarding-welcome',
            'title' => 'Selamat Datang Bapak/Ibu Tentor! 📚',
            'description' => 'Selamat datang di Bimbel Pelita Ilmu. Melalui dashboard ini, Anda dapat memantau kelompok belajar dan melakukan presensi siswa dengan praktis.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => 'a[href*="/behindpelita/jadwal-kelompoks"]',
            'title' => 'Jadwal & Sesi Mengajar 🕒',
            'description' => 'Lihat jadwal kelas Anda, ruangan yang digunakan, dan waktu sesi. Presensi dapat dilakukan langsung saat rentang jam belajar berlangsung.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => 'a[href*="/behindpelita/detail-presensis"]',
            'title' => 'Presensi Siswa ✍️',
            'description' => 'Catat kehadiran siswa di kelas Anda secara langsung. Siswa berstatus Belum Mulai maupun Nonaktif tetap dapat diabsen sesuai kebutuhan.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => 'a[href*="/behindpelita/rekap-presensi-matrix"]',
            'title' => 'Rekap Presensi Matrix 📊',
            'description' => 'Pantau rekap kehadiran seluruh sesi belajar secara horizontal dan unduh laporan kapan saja.',
            'side' => 'right',
            'align' => 'start',
        ],
        [
            'element' => '#onboarding-bantuan-btn',
            'title' => 'Bantuan & Panduan 💡',
            'description' => 'Klik menu Bantuan kapan pun Anda ingin membuka kembali panduan ini. Selamat mengajar!',
            'side' => 'right',
            'align' => 'end',
        ],
    ],
];
