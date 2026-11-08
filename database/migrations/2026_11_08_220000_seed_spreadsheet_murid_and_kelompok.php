<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\MataPelajaran;
use App\Models\Kelompok;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Pembayaran;

return new class extends Migration
{
    public function up(): void
    {
        $mapels = array (
  0 => 'Calistung & Tematik TK',
  1 => 'Tematik SD',
  2 => 'Matematika SD',
  3 => 'IPA SD',
  4 => 'Bahasa Indonesia SD',
  5 => 'Matematika SMP',
  6 => 'IPA SMP',
  7 => 'Bahasa Inggris SMP',
  8 => 'Matematika SMA',
  9 => 'Fisika SMA',
  10 => 'Kimia SMA',
  11 => 'Biologi SMA',
  12 => 'Bahasa Inggris SMA',
  13 => 'Ekonomi & Soshum SMA',
  14 => 'SNBT / UTBK Intensif',
);
        $mapelMap = [];
        foreach ($mapels as $m) {
            $record = MataPelajaran::firstOrCreate(['nama_mapel' => $m]);
            $mapelMap[$m] = $record->id;
        }

        $tentor1 = User::where('role', 'TENTOR')->first() ?? User::first();
        $tentor2 = User::where('role', 'TENTOR')->skip(1)->first() ?? $tentor1;
        $admin = User::where('role', 'ADMIN')->first() ?? User::first();
        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $groups = array (
  0 => 
  array (
    'nama_kelompok' => 'Kelompok TK - Calistung & Motorik',
    'mapel_name' => 'Calistung & Tematik TK',
    'jadwal_hari' => 'Senin & Rabu',
    'jam_mulai' => '15:30:00',
    'jam_selesai' => '17:00:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Adiba Fardina Adha',
        'asal_sekolah' => 'RA Permata Belia',
        'kelas' => 'TK',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Calistung',
          1 => 'Membaca',
          2 => 'Berhitung',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2020-07-31',
        'alamat_rumah' => 'Jl. Penataran RT 6 RW 3, Kalipancur,Ngaliyan',
        'no_telp_siswa' => '085712051029',
        'nama_ortu' => 'Anngy audina',
        'no_telp_ortu' => '085712051029',
        'biaya_bulanan' => 150000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Rafanizan Mehrdad Chala',
        'asal_sekolah' => 'TK ABA 54',
        'kelas' => 'TK',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Calistung',
          1 => 'Membaca',
          2 => 'Berhitung',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2022-01-23',
        'alamat_rumah' => 'Candi penataran 1 no 16',
        'no_telp_siswa' => '-',
        'nama_ortu' => '0896359671610',
        'no_telp_ortu' => '08970077547',
        'biaya_bulanan' => 150000.0,
      ),
    ),
  ),
  1 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 1 SD - Tematik Terpadu',
    'mapel_name' => 'Tematik SD',
    'jadwal_hari' => 'Senin & Rabu',
    'jam_mulai' => '15:30:00',
    'jam_selesai' => '17:00:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Kenizia Sekar Raudhisya Susilo',
        'asal_sekolah' => 'SDI AL MADINA',
        'kelas' => '1 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'Bahasa Indonesia',
          2 => 'IPA',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2020-01-23',
        'alamat_rumah' => 'Jalan Candi Berlian IV no 25 (Perum Pasadena)',
        'no_telp_siswa' => '081901215656',
        'nama_ortu' => 'Kartikasari Kusuma Putri',
        'no_telp_ortu' => '081901215656',
        'biaya_bulanan' => 150000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Muhammad Falih Aqmar Saputra',
        'asal_sekolah' => 'SD Islam Bintang Juara',
        'kelas' => '1 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'Bahasa Indonesia',
          2 => 'IPA',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2019-10-22',
        'alamat_rumah' => 'Jl.Srikaron Utara No 66  Rt 01 Rw 06 Purwoyoso Ngaliyan',
        'no_telp_siswa' => '085641147023',
        'nama_ortu' => 'Arifah Nur Hidayati',
        'no_telp_ortu' => '085641147023',
        'biaya_bulanan' => 150000.0,
      ),
    ),
  ),
  2 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 2 SD - Tematik Terpadu',
    'mapel_name' => 'Tematik SD',
    'jadwal_hari' => 'Selasa & Kamis',
    'jam_mulai' => '15:30:00',
    'jam_selesai' => '17:00:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Muhammad Razka Afiq Susilo',
        'asal_sekolah' => 'SDI AL MADINA',
        'kelas' => '2 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'Bahasa Indonesia',
          2 => 'IPA',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2018-07-21',
        'alamat_rumah' => 'Jalan Candi Berlian IV no 25',
        'no_telp_siswa' => '081901215656',
        'nama_ortu' => 'Kartikasari',
        'no_telp_ortu' => '081901215656',
        'biaya_bulanan' => 150000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Raesha Sabhira Mishall Pouran',
        'asal_sekolah' => 'SD Sekaran 01',
        'kelas' => '2 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'Bahasa Indonesia',
          2 => 'IPA',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2018-11-18',
        'alamat_rumah' => 'Graha Mandiri Residance Blok Q No 5 Patemon Gunung Pati Semarang',
        'no_telp_siswa' => '0811351286',
        'nama_ortu' => 'Tri Sunaryo',
        'no_telp_ortu' => '0811842582',
        'biaya_bulanan' => 150000.0,
      ),
    ),
  ),
  3 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 3 SD - Matematika & Tematik',
    'mapel_name' => 'Tematik SD',
    'jadwal_hari' => 'Senin & Rabu',
    'jam_mulai' => '16:00:00',
    'jam_selesai' => '17:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'CELLO DAFA ALMALIK',
        'asal_sekolah' => 'SDN KALIPANCUR 01',
        'kelas' => '3 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'Bahasa Indonesia',
          2 => 'IPA',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2016-12-25',
        'alamat_rumah' => 'Jl.candi Penataran timur X11 RT03/RW04 Kalipancur Semarang Barat ',
        'no_telp_siswa' => '081227967557',
        'nama_ortu' => 'ANTON PRABOWO/ASIH WULANDARI ',
        'no_telp_ortu' => '085848452821',
        'biaya_bulanan' => 150000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Aiyra Galuh Ghania',
        'asal_sekolah' => 'SD Al-Madina',
        'kelas' => '3 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'Bahasa Indonesia',
          2 => 'IPA',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2018-05-30',
        'alamat_rumah' => 'Jl. Mendut 2 No.10 Semarang',
        'no_telp_siswa' => '081229737133',
        'nama_ortu' => 'Yulia',
        'no_telp_ortu' => '081229737133',
        'biaya_bulanan' => 150000.0,
      ),
    ),
  ),
  4 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 4 SD - Matematika & IPA',
    'mapel_name' => 'Matematika SD',
    'jadwal_hari' => 'Selasa & Kamis',
    'jam_mulai' => '16:00:00',
    'jam_selesai' => '17:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Naira Adhiniswara',
        'asal_sekolah' => 'SD Hj. Isriati Baiturrahman 2',
        'kelas' => '4 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2016-07-24',
        'alamat_rumah' => 'Jl. Roro jonggrang tomur no. 29 rt 8 rw 9, manyaran, semarang barat',
        'no_telp_siswa' => '085196852191',
        'nama_ortu' => 'Widi Arti',
        'no_telp_ortu' => '082327372090',
        'biaya_bulanan' => 150000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Keyla Azqiara Maulidina',
        'asal_sekolah' => 'SDN Manyaran 03 Semarang ',
        'kelas' => '4 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2016-12-12',
        'alamat_rumah' => 'Jl Rorojonggrang Timur XIII no 18 ',
        'no_telp_siswa' => '0.0',
        'nama_ortu' => '0895703381199',
        'no_telp_ortu' => '081227240460',
        'biaya_bulanan' => 150000.0,
      ),
    ),
  ),
  5 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 5 SD - Matematika & IPA',
    'mapel_name' => 'Matematika SD',
    'jadwal_hari' => 'Rabu & Jumat',
    'jam_mulai' => '16:00:00',
    'jam_selesai' => '17:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Alvaro Nizam Pratama',
        'asal_sekolah' => 'SDN Kalibanteng Kidul 03',
        'kelas' => '5 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2015-10-07',
        'alamat_rumah' => 'Jl.rorojonggrang 17 rt 05 rw 10 manyaran',
        'no_telp_siswa' => '+62 882-2175-3786',
        'nama_ortu' => 'Agus Sulistyono',
        'no_telp_ortu' => '085257983234',
        'biaya_bulanan' => 150000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Khansa Anindita Alesha Nugraha',
        'asal_sekolah' => 'SD hj Isriati Baiturrahman 2',
        'kelas' => '5 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2016-02-11',
        'alamat_rumah' => 'Jl.Sriwibowo VI no.3 rt 01 rw 03 kel.purwoyoso,kec.ngaliyan',
        'no_telp_siswa' => '082287877575',
        'nama_ortu' => 'Febiasti',
        'no_telp_ortu' => '082287877575',
        'biaya_bulanan' => 150000.0,
      ),
    ),
  ),
  6 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 6 SD - Sukses Ujian Sekolah',
    'mapel_name' => 'Matematika SD',
    'jadwal_hari' => 'Senin & Kamis',
    'jam_mulai' => '16:00:00',
    'jam_selesai' => '17:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Azka Athala Aryanto',
        'asal_sekolah' => 'SDN kalibanteng kidul 01',
        'kelas' => '6 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA',
          2 => 'Bahasa Indonesia',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-12',
        'tanggal_lahir' => '2014-07-30',
        'alamat_rumah' => 'Bukit panjangan asri blok N 2',
        'no_telp_siswa' => '08882501431',
        'nama_ortu' => 'Yudhi Haryanto',
        'no_telp_ortu' => '082133600636',
        'biaya_bulanan' => 195000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Aqila Khanza Assyifa',
        'asal_sekolah' => 'SDN Manyaran 02',
        'kelas' => '6 SD',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA',
          2 => 'Bahasa Indonesia',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2015-07-11',
        'alamat_rumah' => 'Jl Candi pawon 3 no 12 rt 2 rw 3',
        'no_telp_siswa' => '0895-3790-75235',
        'nama_ortu' => 'Penny Setyowati Nugraheny',
        'no_telp_ortu' => '081901906058',
        'biaya_bulanan' => 195000.0,
      ),
    ),
  ),
  7 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 7 SMP - Matematika & IPA',
    'mapel_name' => 'Matematika SMP',
    'jadwal_hari' => 'Selasa & Jumat',
    'jam_mulai' => '16:00:00',
    'jam_selesai' => '17:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Berinth silvi kerstiana',
        'asal_sekolah' => 'SMP 41',
        'kelas' => '7 SMP',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA Fisika',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-11',
        'tanggal_lahir' => NULL,
        'alamat_rumah' => 'ROROJONGGRANG V RT4 RE 3',
        'no_telp_siswa' => '8.973180447E9',
        'nama_ortu' => '8.136227709E9',
        'no_telp_ortu' => '8.136227709E9',
        'biaya_bulanan' => 140000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Angelyn ayunindyah',
        'asal_sekolah' => 'Smpn 1 semarang',
        'kelas' => '7 SMP',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA Fisika',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2014-04-14',
        'alamat_rumah' => 'Jl borobudur raya 3 Rt 03 Rw XI',
        'no_telp_siswa' => '+62 821-4296-5437',
        'nama_ortu' => 'Bayu aryudi',
        'no_telp_ortu' => '081330054003',
        'biaya_bulanan' => 140000.0,
      ),
    ),
  ),
  8 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 8 SMP - Matematika & IPA',
    'mapel_name' => 'Matematika SMP',
    'jadwal_hari' => 'Senin & Rabu',
    'jam_mulai' => '17:00:00',
    'jam_selesai' => '18:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'ZAKY AKMAL PRANATA',
        'asal_sekolah' => 'SMP 19 SEMARANG ',
        'kelas' => '8 SMP',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA Fisika',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-11',
        'tanggal_lahir' => '2012-04-25',
        'alamat_rumah' => 'Borobudur Timur 14',
        'no_telp_siswa' => '+62-858-6806-4695',
        'nama_ortu' => 'Arbaina',
        'no_telp_ortu' => '+62-859-5034-1984',
        'biaya_bulanan' => 190000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Farah Atikah Putri',
        'asal_sekolah' => 'SMP ISLAM AL-AZHAR 23 SEMARANG',
        'kelas' => '8 SMP',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA Fisika',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2012-11-07',
        'alamat_rumah' => 'Jl.Taman Sri Rejeki Selatan VI RT.01 RW.04 No.29',
        'no_telp_siswa' => '081276460567',
        'nama_ortu' => 'Etika',
        'no_telp_ortu' => '085103565886',
        'biaya_bulanan' => 190000.0,
      ),
    ),
  ),
  9 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 9 SMP - Sukses ASPD & Ujian Akhir',
    'mapel_name' => 'IPA SMP',
    'jadwal_hari' => 'Selasa & Kamis',
    'jam_mulai' => '17:00:00',
    'jam_selesai' => '18:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Alecia erlyna windyaputri',
        'asal_sekolah' => 'SMPN 19 semarang',
        'kelas' => '9 SMP',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA Biologi/Fisika',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-11',
        'tanggal_lahir' => '2011-12-16',
        'alamat_rumah' => 'Jl. Borobudur utara IX rt7 rw3 ',
        'no_telp_siswa' => '087770878826',
        'nama_ortu' => 'Indra windyastanto',
        'no_telp_ortu' => '087780496821',
        'biaya_bulanan' => 190000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Clarista Putri Novitasari',
        'asal_sekolah' => 'SMP N 19 SEMARANG ',
        'kelas' => '9 SMP',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika',
          1 => 'IPA Biologi/Fisika',
          2 => 'Bahasa Inggris',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2011-11-27',
        'alamat_rumah' => 'Jl taman Borobudur Utara IX RT 07 RW 10 ',
        'no_telp_siswa' => '088807847253',
        'nama_ortu' => 'Ika Fera Septiana',
        'no_telp_ortu' => '+62 857-2713-0042',
        'biaya_bulanan' => 190000.0,
      ),
    ),
  ),
  10 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 10 SMA - Matematika & Sains',
    'mapel_name' => 'Matematika SMA',
    'jadwal_hari' => 'Senin & Rabu',
    'jam_mulai' => '17:00:00',
    'jam_selesai' => '18:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Fatimah Syafira Nur Alwi',
        'asal_sekolah' => 'SMAN 7 Semarang ',
        'kelas' => '10 SMA',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika Wajib',
          1 => 'Fisika',
          2 => 'Kimia',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2010-12-07',
        'alamat_rumah' => 'jl wahyu asri utara IX DD 26
Ngaliyan',
        'no_telp_siswa' => '085729894602',
        'nama_ortu' => '085292273355',
        'no_telp_ortu' => '085292273355',
        'biaya_bulanan' => 200000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Emmanuella Rebecca Kenzie',
        'asal_sekolah' => 'SMA NEGERI 7',
        'kelas' => '10 SMA',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika Wajib',
          1 => 'Fisika',
          2 => 'Kimia',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2011-12-05',
        'alamat_rumah' => 'Jl. Candi Prambanan Tengah IV/740',
        'no_telp_siswa' => '083838262472',
        'nama_ortu' => 'Fransisca Widyastuti',
        'no_telp_ortu' => '081805886487',
        'biaya_bulanan' => 200000.0,
      ),
    ),
  ),
  11 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 11 SMA - MIPA Unggulan',
    'mapel_name' => 'Kimia SMA',
    'jadwal_hari' => 'Selasa & Jumat',
    'jam_mulai' => '17:00:00',
    'jam_selesai' => '18:30:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'LEANDRA FEODORA KENZIE',
        'asal_sekolah' => 'SMA NEGERI 6 SEMARANG',
        'kelas' => '11 SMA',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika Tingkat Lanjut',
          1 => 'Kimia',
          2 => 'Fisika',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2010-03-03',
        'alamat_rumah' => 'Jl. Candi Prambanan Tengah IV/740',
        'no_telp_siswa' => '083867182752',
        'nama_ortu' => 'Fransisca Widyastuti',
        'no_telp_ortu' => '081805886487',
        'biaya_bulanan' => 230000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Kayyis Qurrota \'Aini',
        'asal_sekolah' => 'SMAN 5 SEMARANG',
        'kelas' => '11 SMA',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Matematika Tingkat Lanjut',
          1 => 'Kimia',
          2 => 'Fisika',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2010-06-30',
        'alamat_rumah' => 'Jl. Bulustalan 2 no. 66',
        'no_telp_siswa' => '087773137952',
        'nama_ortu' => 'Anna Julianti',
        'no_telp_ortu' => '081325375293',
        'biaya_bulanan' => 230000.0,
      ),
    ),
  ),
  12 => 
  array (
    'nama_kelompok' => 'Kelompok Kelas 12 SMA - Sukses SNBT & UTBK',
    'mapel_name' => 'SNBT / UTBK Intensif',
    'jadwal_hari' => 'Senin & Kamis',
    'jam_mulai' => '18:30:00',
    'jam_selesai' => '20:00:00',
    'siswa' => 
    array (
      0 => 
      array (
        'nama_lengkap' => 'Imanuel Calvianus Davi Suseno',
        'asal_sekolah' => 'SMAN 7 ',
        'kelas' => '12 SMA',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Penalaran Matematika',
          1 => 'Literasi B. Indonesia',
          2 => 'Pengetahuan Kuantitatif',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-12',
        'tanggal_lahir' => '2009-09-26',
        'alamat_rumah' => 'Jl. Candi Tembaga Raya No 656',
        'no_telp_siswa' => '08986439839',
        'nama_ortu' => 'Vitriyani',
        'no_telp_ortu' => '+62 881-6826-956',
        'biaya_bulanan' => 290000.0,
      ),
      1 => 
      array (
        'nama_lengkap' => 'Ika Nur Wahyuni',
        'asal_sekolah' => 'SMA Negeri 7 Semarang',
        'kelas' => '12 SMA',
        'kategori_kelas' => 'Reguler',
        'pilihan_mapel' => 
        array (
          0 => 'Penalaran Matematika',
          1 => 'Literasi B. Indonesia',
          2 => 'Pengetahuan Kuantitatif',
        ),
        'tipe_belajar' => 'KELOMPOK',
        'tipe_jatuh_tempo' => 'AWAL BULAN',
        'status_siswa' => 'AKTIF',
        'tanggal_daftar' => '2026-10-10',
        'tanggal_lahir' => '2008-04-27',
        'alamat_rumah' => 'Jalan Tambakharjo Rt 1 Rw 7',
        'no_telp_siswa' => '085875299217',
        'nama_ortu' => 'Miati',
        'no_telp_ortu' => '085701137072',
        'biaya_bulanan' => 290000.0,
      ),
    ),
  ),
);

        foreach ($groups as $idx => $g) {
            $tentorId = ($idx % 2 === 0) ? ($tentor1?->id ?? 1) : ($tentor2?->id ?? 1);
            $kelompok = Kelompok::updateOrCreate(
                ['nama_kelompok' => $g['nama_kelompok']],
                [
                    'mapel_id' => $mapelMap[$g['mapel_name']] ?? 1,
                    'tentor_id' => $tentorId,
                    'jadwal_hari' => $g['jadwal_hari'],
                    'jam_mulai' => $g['jam_mulai'],
                    'jam_selesai' => $g['jam_selesai'],
                ]
            );

            foreach ($g['siswa'] as $sData) {
                $siswa = Siswa::updateOrCreate(
                    ['nama_lengkap' => $sData['nama_lengkap']],
                    [
                        'asal_sekolah' => $sData['asal_sekolah'],
                        'kelas' => $sData['kelas'],
                        'kategori_kelas' => $sData['kategori_kelas'],
                        'pilihan_mapel' => $sData['pilihan_mapel'],
                        'tipe_belajar' => $sData['tipe_belajar'],
                        'tipe_jatuh_tempo' => $sData['tipe_jatuh_tempo'],
                        'status_siswa' => $sData['status_siswa'],
                        'tanggal_daftar' => $sData['tanggal_daftar'],
                        'tanggal_lahir' => $sData['tanggal_lahir'],
                        'alamat_rumah' => $sData['alamat_rumah'],
                        'no_telp_siswa' => $sData['no_telp_siswa'],
                        'nama_ortu' => $sData['nama_ortu'],
                        'no_telp_ortu' => $sData['no_telp_ortu'],
                        'biaya_bulanan' => $sData['biaya_bulanan'],
                    ]
                );

                DB::table('pemetaan_kelompok')->updateOrInsert(
                    ['siswa_id' => $siswa->id, 'kelompok_id' => $kelompok->id],
                    ['created_at' => $now, 'updated_at' => $now]
                );

                Pembayaran::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'untuk_bulan' => $currentMonth,
                        'untuk_tahun' => $currentYear,
                    ],
                    [
                        'admin_pencatat_id' => $admin?->id ?? 1,
                        'biaya_dibayar' => $sData['biaya_bulanan'],
                        'metode_bayar' => 'QRIS',
                        'status_bayar' => 'LUNAS',
                        'tanggal_bayar' => $now->toDateString(),
                    ]
                );
            }
        }
    }

    public function down(): void
    {
    }
};