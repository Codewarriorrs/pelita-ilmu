<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        $duplicates = DB::table('pembayaran')
            ->select('siswa_id', 'untuk_bulan', 'untuk_tahun')
            ->groupBy('siswa_id', 'untuk_bulan', 'untuk_tahun')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            $ids = DB::table('pembayaran')
                ->where('siswa_id', $dup->siswa_id)
                ->where('untuk_bulan', $dup->untuk_bulan)
                ->where('untuk_tahun', $dup->untuk_tahun)
                ->orderByRaw("CASE WHEN status_bayar = 'LUNAS' THEN 0 ELSE 1 END ASC")
                ->orderByDesc('id')
                ->pluck('id')
                ->all();

            if (count($ids) > 1) {
                array_shift($ids);
                DB::table('pembayaran')->whereIn('id', $ids)->delete();
            }
        }

        Schema::table('pembayaran', function (Blueprint $table): void {
            $table->unique(['siswa_id', 'untuk_bulan', 'untuk_tahun'], 'pembayaran_siswa_bulan_tahun_unique');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table): void {
            $table->dropUnique('pembayaran_siswa_bulan_tahun_unique');
        });
    }
};

