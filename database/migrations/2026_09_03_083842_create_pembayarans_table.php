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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('admin_pencatat_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('biaya_dibayar', 12, 2);
            $table->enum('metode_bayar', ['TUNAI', 'TRANSFER', 'QRIS'])->default('TUNAI');
            $table->enum('status_bayar', ['LUNAS', 'BELUM'])->default('BELUM');
            $table->dateTime('tanggal_bayar')->nullable();
            $table->unsignedTinyInteger('untuk_bulan'); // 1 - 12 (misal: 8 = Agustus)
            $table->year('untuk_tahun'); // Contoh: 2026
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
