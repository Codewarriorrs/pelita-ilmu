<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        if (!Schema::hasColumn('siswa', 'kelas')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->string('kelas')->nullable();
            });
        }
        if (!Schema::hasColumn('siswa', 'pilihan_mapel')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->json('pilihan_mapel')->nullable();
            });
        }

        // Jalankan seeder baru agar sinkron dengan kebutuhan simulasi testing
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\DatabaseSeeder',
            '--force' => true,
        ]);
    }

    public function down(): void
    {
    }
};
