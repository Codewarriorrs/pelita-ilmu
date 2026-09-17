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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('asal_sekolah')->nullable();
            $table->string('kategori_kelas')->nullable(); // contoh: SD, SMP, SMA
            $table->enum('tipe_belajar', ['PRIVAT', 'KELOMPOK'])->default('KELOMPOK');
            $table->enum('tipe_jatuh_tempo', ['AWAL BULAN', 'AKHIR BULAN'])->default('AWAL BULAN');
            $table->enum('status_siswa', ['CALON', 'AKTIF', 'NONAKTIF'])->default('CALON');
            $table->dateTime('tanggal_daftar')->useCurrent();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('no_telp_siswa', 20)->nullable();
            $table->string('nama_ortu')->nullable();
            $table->string('no_telp_ortu', 20)->nullable();
            $table->decimal('biaya_bulanan', 12, 2)->default(0);
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
