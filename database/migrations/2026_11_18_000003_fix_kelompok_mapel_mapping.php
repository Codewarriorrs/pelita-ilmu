<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pastikan mapel standar ada
        $mapels = [
            'IPA' => DB::table('mata_pelajaran')->where('nama_mapel', 'IPA')->where('jenjang', 'SMP')->value('id'),
            'IPA Fisika' => DB::table('mata_pelajaran')->where('nama_mapel', 'IPA Fisika')->where('jenjang', 'SMP')->value('id'),
            'IPA Biologi' => DB::table('mata_pelajaran')->where('nama_mapel', 'IPA Biologi')->where('jenjang', 'SMP')->value('id'),
            'Matematika' => DB::table('mata_pelajaran')->where('nama_mapel', 'Matematika')->where('jenjang', 'SMP')->value('id'),
            'Bahasa Inggris' => DB::table('mata_pelajaran')->where('nama_mapel', 'Bahasa Inggris')->where('jenjang', 'SMP')->value('id'),
            'Bahasa Indonesia' => DB::table('mata_pelajaran')->where('nama_mapel', 'Bahasa Indonesia')->where('jenjang', 'SMP')->value('id'),
            'IPS' => DB::table('mata_pelajaran')->where('nama_mapel', 'IPS')->where('jenjang', 'SMP')->value('id'),
            'TKA Matematika' => DB::table('mata_pelajaran')->where('nama_mapel', 'TKA Matematika')->where('jenjang', 'SMP')->value('id'),
            'TKA Bahasa Indonesia' => DB::table('mata_pelajaran')->where('nama_mapel', 'TKA Bahasa Indonesia')->where('jenjang', 'SMP')->value('id'),
            'Calistung TK' => DB::table('mata_pelajaran')->where('nama_mapel', 'Calistung & Tematik TK')->where('jenjang', 'TK')->value('id'),
        ];

        // Buat mapel jika belum ada
        if (!$mapels['Matematika']) {
            $mapels['Matematika'] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel' => 'Matematika',
                'jenjang' => 'SMP',
                'tingkat_kelas' => 'Kelas 7-9 SMP',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if (!$mapels['Bahasa Indonesia']) {
            $mapels['Bahasa Indonesia'] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel' => 'Bahasa Indonesia',
                'jenjang' => 'SMP',
                'tingkat_kelas' => 'Kelas 7-9 SMP',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if (!$mapels['TKA Bahasa Indonesia']) {
            $mapels['TKA Bahasa Indonesia'] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel' => 'TKA Bahasa Indonesia',
                'jenjang' => 'SMP',
                'tingkat_kelas' => 'Kelas 8-9 SMP',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        if (!$mapels['TKA Matematika']) {
            $mapels['TKA Matematika'] = DB::table('mata_pelajaran')->insertGetId([
                'nama_mapel' => 'TKA Matematika',
                'jenjang' => 'SMP',
                'tingkat_kelas' => 'Kelas 8-9 SMP',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Perbaiki pemetaan kelompok SMP yang keliru mapel_id nya
        // 1. TKA B INDO -> TKA Bahasa Indonesia
        DB::table('kelompok')
            ->where(function ($q) {
                $q->where('nama_kelompok', 'ILIKE', '%TKA B INDO%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%TKA B. INDO%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%TKA BI%');
            })
            ->update(['mapel_id' => $mapels['TKA Bahasa Indonesia'], 'jenjang' => 'SMP']);

        // 2. TKA MTK -> TKA Matematika
        DB::table('kelompok')
            ->where('nama_kelompok', 'ILIKE', '%TKA MTK%')
            ->update(['mapel_id' => $mapels['TKA Matematika'], 'jenjang' => 'SMP']);

        // 3. KELAS 7/8/9 MTK -> Matematika SMP
        DB::table('kelompok')
            ->where(function ($q) {
                $q->where('nama_kelompok', 'ILIKE', '%KELAS 7 MTK%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 8 MTK%')
                  ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 9 MTK%');
            })
            ->update(['mapel_id' => $mapels['Matematika'], 'jenjang' => 'SMP']);

        // 4. KELAS 7/8/9 IPA -> IPA SMP
        if ($mapels['IPA']) {
            DB::table('kelompok')
                ->where(function ($q) {
                    $q->where('nama_kelompok', 'ILIKE', '%KELAS 7 IPA%')
                      ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 8 IPA%')
                      ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 9 IPA%');
                })
                ->where('nama_kelompok', 'NOT ILIKE', '%FISIKA%')
                ->where('nama_kelompok', 'NOT ILIKE', '%BIOLOGI%')
                ->update(['mapel_id' => $mapels['IPA'], 'jenjang' => 'SMP']);
        }

        // 5. KELAS 7/8/9 ING -> Bahasa Inggris SMP
        if ($mapels['Bahasa Inggris']) {
            DB::table('kelompok')
                ->where(function ($q) {
                    $q->where('nama_kelompok', 'ILIKE', '%KELAS 7 ING%')
                      ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 8 ING%')
                      ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 9 ING%');
                })
                ->update(['mapel_id' => $mapels['Bahasa Inggris'], 'jenjang' => 'SMP']);
        }

        // 6. KELAS 7/8/9 IPS -> IPS SMP
        if ($mapels['IPS']) {
            DB::table('kelompok')
                ->where(function ($q) {
                    $q->where('nama_kelompok', 'ILIKE', '%KELAS 7 IPS%')
                      ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 8 IPS%')
                      ->orWhere('nama_kelompok', 'ILIKE', '%KELAS 9 IPS%');
                })
                ->update(['mapel_id' => $mapels['IPS'], 'jenjang' => 'SMP']);
        }
    }

    public function down(): void
    {
    }
};
