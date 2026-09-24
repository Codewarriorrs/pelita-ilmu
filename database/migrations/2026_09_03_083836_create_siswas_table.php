<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('asal_sekolah')->nullable();
            $table->string('kelas')->nullable();
            $table->string('kategori_kelas')->nullable(); // contoh: SD, SMP, SMA
            $table->json('pilihan_mapel')->nullable();
            $table->string('tipe_belajar', 20)->default('KELOMPOK');
            $table->string('tipe_jatuh_tempo', 20)->default('AWAL BULAN');
            $table->string('status_siswa', 20)->default('CALON');
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
