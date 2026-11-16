<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        if (! Schema::hasColumn('siswa', 'tanggal_keluar')) {
            Schema::table('siswa', function (Blueprint $table): void {
                $table->date('tanggal_keluar')->nullable()->after('tanggal_daftar');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('siswa', 'tanggal_keluar')) {
            Schema::table('siswa', function (Blueprint $table): void {
                $table->dropColumn('tanggal_keluar');
            });
        }
    }
};

