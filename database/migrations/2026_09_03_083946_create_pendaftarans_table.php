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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('asal_sekolah')->nullable();
            $table->string('kelas')->nullable();
            $table->string('kategori_kelas')->default('Reguler');
            $table->string('program_belajar')->nullable();
            $table->json('pilihan_mapel')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_ortu')->nullable();
            $table->string('no_telp_ortu', 20)->nullable();
            $table->string('no_telp_siswa', 20)->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('minat_program')->nullable();
            $table->string('nomor_wa', 20)->nullable();
            $table->string('status_tindak_lanjut', 20)->default('BARU');
            $table->dateTime('tanggal_masuk')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
