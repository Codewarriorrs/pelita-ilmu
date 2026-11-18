<?php

return [
    // ==========================================
    // 1. TOUR SPESIFIK HALAMAN DASHBOARD UTAMA
    // ==========================================
    'dashboard' => [
        [
            'element' => '#onboarding-welcome',
            'title' => 'Selamat Datang di Bimbel Pelita Ilmu',
            'description' => 'Mari kami pandu mengenal fitur-fitur utama sistem agar pengelolaan operasional, siswa, dan keuangan bimbel Anda semakin lancar.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => '.fi-topbar .fi-global-search-field, .fi-global-search-field',
            'title' => 'Pencarian Cepat Seluruh Fitur',
            'description' => 'Ketikkan nama fitur, menu, atau data siswa di sini untuk langsung menuju halaman atau tindakan yang diinginkan.',
            'side' => 'bottom',
            'align' => 'start',
        ],
        [
            'element' => '#pelita-bell-btn, .pelita-bell-btn',
            'title' => 'Lonceng Notifikasi & Aktivitas',
            'description' => 'Lihat pembaruan penting secara langsung: pendaftaran calon murid baru masuk dan jadwal mengajar hari ini.',
            'side' => 'bottom',
            'align' => 'end',
        ],
        [
            'element' => '.fi-wi-stats-overview, .filament-stats-overview-widget',
            'title' => 'Kartu Statistik Operasional',
            'description' => 'Pantau metrik utama bimbel: jumlah total murid aktif, kelompok belajar yang berjalan, dan ringkasan pembayaran SPP.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => '.fi-sidebar-nav',
            'title' => 'Menu Navigasi Sidebar',
            'description' => 'Gunakan navigasi samping untuk berpindah antar modul: Data Siswa, Pendaftaran, Jadwal & Presensi, Keuangan, dan Pengaturan Ruangan.',
            'side' => 'right',
            'align' => 'start',
        ],
    ],

    // ==========================================
    // 2. TOUR SPESIFIK HALAMAN JADWAL & PRESENSI
    // ==========================================
    'jadwal-kelompoks' => [
        [
            'element' => 'a[href*="/jadwal-kelompoks/create"], .fi-ta-header-ctn .fi-btn-primary',
            'title' => 'Tambah Jadwal Sesi Baru',
            'description' => 'Klik tombol ini untuk menjadwalkan pertemuan kelas baru, menentukan tentor pengampu, dan memilih ruang kelas yang tidak bentrok.',
            'side' => 'bottom',
            'align' => 'start',
        ],
        [
            'element' => '.fi-ta-search-field',
            'title' => 'Cari Jadwal Pertemuan',
            'description' => 'Cari jadwal sesi berdasarkan nama rombel, materi pelajaran, atau tanggal pertemuan secara cepat.',
            'side' => 'bottom',
            'align' => 'start',
        ],
        [
            'element' => '.fi-ta-table tbody tr:first-child .fi-ta-actions, .fi-ta-actions',
            'title' => 'Aksi Presensi & Kehadiran',
            'description' => 'Klik ikon checklist (lembar centang) pada baris sesi untuk membuka formulir absensi dan mencatat kehadiran siswa (Hadir, Izin, Sakit, Alpa).',
            'side' => 'top',
            'align' => 'center',
        ],
    ],

    // ==========================================
    // 3. TOUR SPESIFIK HALAMAN DATA SISWA
    // ==========================================
    'siswas' => [
        [
            'element' => 'a[href*="/siswas/create"], .fi-ta-header-ctn .fi-btn-primary',
            'title' => 'Tambah Siswa Baru',
            'description' => 'Tambahkan data siswa secara manual lengkap dengan jenjang, kelas, kontak orang tua, dan biaya bulanan (SPP).',
            'side' => 'bottom',
            'align' => 'start',
        ],
        [
            'element' => '.page-siswa .fi-ta-table tbody tr:first-child',
            'title' => 'Kartu Accordion Siswa (Mobile Friendly)',
            'description' => 'Klik nama siswa untuk membuka detail informasi kontak, asal sekolah, dan daftar kelompok belajar yang sedang diikuti.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => '.fi-ta-filters',
            'title' => 'Filter Status Keaktifan Siswa',
            'description' => 'Saring siswa berdasarkan status: AKTIF, BELUM MULAI, atau NONAKTIF untuk pengelolaan data yang rapi.',
            'side' => 'bottom',
            'align' => 'end',
        ],
    ],

    // ==========================================
    // 4. TOUR SPESIFIK HALAMAN PENDAFTARAN ONLINE
    // ==========================================
    'pendaftarans' => [
        [
            'element' => '.fi-ta-table tbody tr:first-child',
            'title' => 'Daftar Calon Murid Masuk',
            'description' => 'Setiap pendaftaran online dari website akan masuk ke sini dengan status tindak lanjut (Baru, Dihubungi, Diterima).',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => '.fi-ta-table tbody tr:first-child .fi-ta-actions',
            'title' => 'Tinjau & Verifikasi Pendaftaran',
            'description' => 'Klik tombol Tinjau untuk melihat nota rincian biaya pendaftaran (kaos/reguler), memverifikasi data, dan langsung memilih kelompok belajar siswa.',
            'side' => 'left',
            'align' => 'center',
        ],
    ],

    // ==========================================
    // 5. TOUR SPESIFIK HALAMAN REKAP PEMBAYARAN
    // ==========================================
    'rekap-pembayarans' => [
        [
            'element' => '.fi-wi-widget',
            'title' => 'Kartu Ringkasan & Filter Pemasukan',
            'description' => 'Lihat rincian penerimaan kas berdasarkan metode pembayaran (Tunai, Transfer, QRIS) dan saring periode per Hari Ini, Bulan Ini, atau Keseluruhan.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => 'a[href*="/pembayarans/create"], .fi-btn-primary',
            'title' => 'Catat Pembayaran Baru',
            'description' => 'Gunakan tombol ini untuk mencatat pembayaran SPP bulanan siswa yang masuk baik via tunai maupun transfer.',
            'side' => 'bottom',
            'align' => 'start',
        ],
    ],

    // ==========================================
    // 6. TOUR SPESIFIK KELOMPOK BELAJAR
    // ==========================================
    'kelompoks' => [
        [
            'element' => 'a[href*="/kelompoks/create"], .fi-btn-primary',
            'title' => 'Buat Kelompok Belajar Baru',
            'description' => 'Buat rombel baru, hubungkan dengan mata pelajaran standar, tentukan tentor pengampu, serta waktu jadwal mingguan.',
            'side' => 'bottom',
            'align' => 'start',
        ],
        [
            'element' => '.fi-ta-table tbody tr:first-child',
            'title' => 'Data Rombel & Kuota Siswa',
            'description' => 'Pantau jumlah murid pada setiap kelompok belajar agar kapasitas kelas tetap ideal dan kondusif.',
            'side' => 'bottom',
            'align' => 'center',
        ],
    ],

    // ==========================================
    // 7. TOUR TENTOR (KHUSUS ROLE TENTOR)
    // ==========================================
    'tentor' => [
        [
            'element' => '#onboarding-welcome',
            'title' => 'Selamat Datang, Bapak/Ibu Guru & Tentor',
            'description' => 'Sistem ini membantu Anda melihat jadwal sesi mengajar hari ini dan mencatat presensi kehadiran siswa dengan mudah.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        [
            'element' => 'a[href*="/behindpelita/jadwal-kelompoks"]',
            'title' => 'Jadwal Mengajar Anda',
            'description' => 'Akses jadwal mengajar harian Anda dan langsung buka sesi presensi saat jam belajar dimulai.',
            'side' => 'right',
            'align' => 'start',
        ],
    ],
];
