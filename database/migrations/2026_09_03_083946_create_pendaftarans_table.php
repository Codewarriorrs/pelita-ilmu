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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('asal_sekolah')->nullable();
            $table->string('minat_program')->nullable();
            $table->string('nomor_wa', 20);
            $table->enum('status_tindak_lanjut', ['BARU', 'DIHUBUNGI', 'DITERIMA'])->default('BARU');
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
