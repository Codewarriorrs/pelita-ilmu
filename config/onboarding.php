<?php

return [
    'admin' => [
        // STEP 1: Sambutan Awal
        [
            'element' => '#onboarding-welcome',
            'title' => 'Selamat Datang di Bimbel Pelita Ilmu',
            'description' => 'Mari kami pandu mengenal fitur-fitur utama sistem agar pengelolaan operasional, siswa, dan keuangan bimbel Anda semakin lancar.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        // STEP 2: Topbar & Pencarian
        [
            'element' => '.fi-topbar input, .fi-global-search-field',
            'title' => 'Pencarian Cepat Data',
            'description' => 'Ketikkan nama siswa, nomor telepon, atau kata kunci untuk menemukan data secara instan di seluruh sistem.',
            'side' => 'bottom',
            'align' => 'start',
        ],
        // STEP 3: Lonceng Notifikasi
        [
            'element' => '#pelita-bell-btn, .pelita-bell-btn',
            'title' => 'Pusat Notifikasi & Aktivitas',
            'description' => 'Klik lonceng ini untuk melihat riwayat aktivitas terbaru seperti pendaftaran baru masuk atau pengingat jadwal sesi mengajar hari ini.',
            'side' => 'bottom',
            'align' => 'end',
        ],
        // STEP 4: Widget Statistik Dashboard
        [
            'element' => '.fi-wi-stats-overview, .filament-stats-overview-widget',
            'title' => 'Ringkasan Statistik Utama',
            'description' => 'Pantau ringkasan total siswa aktif, rombel berjalan, dan ringkasan keuangan terkini secara langsung.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        // STEP 5: Data Siswa (Sidebar)
        [
            'element' => 'a[href*="/behindpelita/siswas"]',
            'title' => 'Manajemen Data Siswa',
            'description' => 'Kelola direktori siswa lengkap, status keaktifan (Aktif, Belum Mulai, Nonaktif), catatan khusus siswa, dan kelompok belajar yang diikuti.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 6: Verifikasi Pendaftaran
        [
            'element' => 'a[href*="/behindpelita/pendaftarans"]',
            'title' => 'Verifikasi Pendaftaran Online',
            'description' => 'Tinjau calon murid baru, cek nota ringkasan biaya pendaftaran, dan langsung tentukan kelompok belajarnya.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 7: Jadwal & Sesi Belajar (Sidebar)
        [
            'element' => 'a[href*="/behindpelita/jadwal-kelompoks"]',
            'title' => 'Penjadwalan & Sesi Belajar',
            'description' => 'Kelola jadwal belajar mingguan, buka sesi presensi mengajar, dan atur pemakaian ruangan kelas.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 8: Tombol Tambah Jadwal / Sesi (Action Button)
        [
            'element' => '.fi-ta-header-ctn .fi-btn-primary, .fi-page-header-actions .fi-btn-primary, a[href*="/behindpelita/jadwal-kelompoks/create"], a[href*="/behindpelita/kelompoks/create"], a[href*="/behindpelita/siswas/create"]',
            'title' => 'Tombol Tambah Data & Sesi Baru',
            'description' => 'Gunakan tombol utama ini untuk membuat jadwal atau sesi belajar baru, mendaftarkan kelompok baru, atau menambah siswa secara manual.',
            'side' => 'bottom',
            'align' => 'end',
        ],
        // STEP 9: Filter & Pencarian Tabel
        [
            'element' => '.fi-ta-header-ctn, .fi-ta-search-field, .fi-ta-filters',
            'title' => 'Filter & Aksi Tabel',
            'description' => 'Setiap tabel dilengkapi pencarian instan dan filter status untuk memudahkan Anda menyaring data dalam hitungan detik.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        // STEP 10: Tombol Aksi Baris (Presensi / Edit / Hapus)
        [
            'element' => '.fi-ta-actions, .fi-ta-record-action, .fi-ta-row:first-child .fi-ta-actions',
            'title' => 'Aksi Cepat Presensi, Edit & Hapus',
            'description' => 'Pada setiap baris data, Anda dapat langsung mengklik ikon presensi untuk mencatat kehadiran siswa saat sesi berlangsung, ikon pensil untuk mengubah data kelas, atau ikon tong sampah untuk menghapus.',
            'side' => 'left',
            'align' => 'center',
        ],
        // STEP 11: Rekap Keuangan
        [
            'element' => 'a[href*="/behindpelita/rekap-pembayarans"]',
            'title' => 'Rekap Pembayaran & SPP',
            'description' => 'Pantau total pemasukan harian dan bulanan dengan filter metode pembayaran (Tunai, Transfer, QRIS), serta catat transaksi baru.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 12: Data Ruangan
        [
            'element' => 'a[href*="/behindpelita/ruangans"]',
            'title' => 'Manajemen Ruang Kelas',
            'description' => 'Kelola daftar ruang kelas beserta kapasitasnya agar penjadwalan sesi belajar tertata rapi.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 13: Tombol Bantuan
        [
            'element' => '#onboarding-bantuan-btn',
            'title' => 'Panduan & Bantuan Mandiri',
            'description' => 'Kapan pun Anda ingin mengulang tur pengenalan ini, cukup klik tombol Bantuan & Panduan ini.',
            'side' => 'right',
            'align' => 'end',
        ],
    ],

    'tentor' => [
        // STEP 1: Sambutan
        [
            'element' => '#onboarding-welcome',
            'title' => 'Selamat Datang Bapak/Ibu Tentor',
            'description' => 'Melalui panel ini, Anda dapat memantau jadwal mengajar, melihat daftar siswa ampu, dan mengisi presensi belajar secara praktis.',
            'side' => 'bottom',
            'align' => 'center',
        ],
        // STEP 2: Jadwal Sesi Mengajar
        [
            'element' => 'a[href*="/behindpelita/jadwal-kelompoks"]',
            'title' => 'Jadwal & Sesi Mengajar',
            'description' => 'Lihat sesi kelas yang Anda ampu, ruangan yang digunakan, serta waktu mulai dan selesai sesi.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 3: Tombol Buat Sesi / Tambah Pertemuan
        [
            'element' => '.fi-ta-header-ctn .fi-btn-primary, .fi-page-header-actions .fi-btn-primary, a[href*="/behindpelita/jadwal-kelompoks/create"]',
            'title' => 'Buat Pertemuan & Sesi Mengajar',
            'description' => 'Klik tombol ini untuk menjadwalkan sesi belajar baru bagi kelompok belajar yang Anda ampu.',
            'side' => 'bottom',
            'align' => 'end',
        ],
        // STEP 4: Ikon Aksi Presensi Langsung
        [
            'element' => '.fi-ta-actions, .fi-ta-record-action, .fi-ta-row:first-child .fi-ta-actions',
            'title' => 'Pengisian Presensi Kelas',
            'description' => 'Klik ikon presensi pada baris sesi yang sedang aktif untuk mulai mencatat kehadiran siswa (Hadir, Izin, Sakit, Alpa). Presensi terbuka selama rentang jam belajar.',
            'side' => 'left',
            'align' => 'center',
        ],
        // STEP 5: Presensi Siswa (Menu)
        [
            'element' => 'a[href*="/behindpelita/detail-presensis"]',
            'title' => 'Riwayat & Detail Presensi',
            'description' => 'Pantau rekap seluruh absensi siswa yang sudah pernah Anda catat pada pertemuan-pertemuan sebelumnya.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 6: Rekap Presensi Matrix
        [
            'element' => 'a[href*="/behindpelita/rekap-presensi-matrix"]',
            'title' => 'Rekapitulasi Kehadiran Siswa',
            'description' => 'Pantau rekap kehadiran kelas bimbingan dalam bentuk tabel matriks horizontal dan unduh ke format Excel/CSV.',
            'side' => 'right',
            'align' => 'start',
        ],
        // STEP 7: Tombol Bantuan
        [
            'element' => '#onboarding-bantuan-btn',
            'title' => 'Pusat Bantuan Tentor',
            'description' => 'Klik menu Bantuan kapan pun Anda membutuhkan panduan penggunaan sistem. Selamat bertugas!',
            'side' => 'right',
            'align' => 'end',
        ],
    ],
];
