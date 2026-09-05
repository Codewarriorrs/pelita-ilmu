<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('asal_sekolah');
            $table->string('kategori_kelas');
            $table->enum('tipe_belajar', ['PRIVAT', 'KELOMPOK']);
            $table->enum('tipe_jatuh_tempo', ['AWAL_BULAN', 'AKHIR_BULAN']);
            $table->enum('status_siswa', ['CALON', 'AKTIF', 'NONAKTIF'])->default('AKTIF');
            $table->date('tanggal_daftar')->nullable();
            $table->date('tanggal_lahir');
            $table->string('alamat_rumah');
            $table->string('no_telp_siswa')->nullable();
            $table->string('nama_ortu');
            $table->string('no_telp_ortu');
            $table->decimal('biaya_bulanan', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
