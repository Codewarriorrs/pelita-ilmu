<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelompok;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationFeedController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        if (! $user) {
            return response()->json(['items' => [], 'unread_count' => 0]);
        }

        $now = Carbon::now();
        $today = $now->toDateString();
        $isTentor = $user->isTentor();

        $notifications = [];

        // 1. Pendaftar Online Baru (Admin only)
        if (! $isTentor) {
            $newRegistrations = Pendaftaran::where('status_tindak_lanjut', 'BARU')
                ->latest('tanggal_masuk')
                ->limit(5)
                ->get();

            foreach ($newRegistrations as $reg) {
                $notifications[] = [
                    'id' => 'reg_' . $reg->id,
                    'type' => 'pendaftaran',
                    'title' => 'Pendaftar Baru Masuk',
                    'message' => $reg->nama_lengkap . ' mendaftar program ' . ($reg->program_belajar ?: $reg->kelas),
                    'time' => $reg->tanggal_masuk ? $reg->tanggal_masuk->diffForHumans() : 'Baru saja',
                    'created_at' => $reg->tanggal_masuk ? $reg->tanggal_masuk->toIso8601String() : $now->toIso8601String(),
                    'url' => url('/behindpelita/pendaftarans'),
                    'color' => '#eab308', // Kuning
                    'icon' => 'user-plus',
                ];
            }
        }

        // 2. Sesi Sedang Berlangsung Hari Ini
        $activeSessions = JadwalKelompok::with(['kelompok.tentor', 'kelompok.mapel'])
            ->whereDate('tanggal_sesi', $today)
            ->where('status_sesi', '!=', 'BATAL')
            ->when($isTentor, function ($q) use ($user) {
                $q->whereHas('kelompok', fn ($kq) => $kq->where('tentor_id', $user->id));
            })
            ->get();

        foreach ($activeSessions as $sesi) {
            $jamMulai = $sesi->kelompok?->jam_mulai;
            $jamSelesai = $sesi->kelompok?->jam_selesai;
            $namaKelompok = $sesi->kelompok?->nama_kelompok ?? 'Sesi Bimbingan';
            $ruang = $sesi->ruang_kelas ? " ({$sesi->ruang_kelas})" : '';

            $isOngoing = false;
            if ($jamMulai && $jamSelesai) {
                $start = Carbon::parse($today . ' ' . $jamMulai);
                $end = Carbon::parse($today . ' ' . $jamSelesai);
                $isOngoing = $now->between($start, $end);
            }

            if ($isOngoing || $sesi->status_sesi === 'DIMULAI') {
                $notifications[] = [
                    'id' => 'sesi_live_' . $sesi->id,
                    'type' => 'sesi_berlangsung',
                    'title' => 'Sesi Sedang Berlangsung',
                    'message' => $namaKelompok . $ruang . ' sedang berjalan (' . substr($jamMulai, 0, 5) . ' - ' . substr($jamSelesai, 0, 5) . ')',
                    'time' => 'Sedang berlangsung',
                    'created_at' => $now->toIso8601String(),
                    'url' => url('/behindpelita/jadwal-kelompoks'),
                    'color' => '#16a34a', // Hijau
                    'icon' => 'play',
                ];
            } elseif ($sesi->status_sesi === 'TERJADWAL') {
                $notifications[] = [
                    'id' => 'sesi_today_' . $sesi->id,
                    'type' => 'sesi_jadwal',
                    'title' => 'Jadwal Sesi Hari Ini',
                    'message' => $namaKelompok . $ruang . ' pukul ' . substr($jamMulai, 0, 5),
                    'time' => 'Hari ini',
                    'created_at' => $now->toIso8601String(),
                    'url' => url('/behindpelita/jadwal-kelompoks'),
                    'color' => '#0284c7', // Biru
                    'icon' => 'calendar',
                ];
            }
        }

        // 3. Siswa Jatuh Tempo & Menunggak Pembayaran (Admin only)
        if (! $isTentor) {
            $currentMonth = (int) $now->month;
            $currentYear = (int) $now->year;

            $paidSiswaIds = Pembayaran::where('untuk_bulan', $currentMonth)
                ->where('untuk_tahun', $currentYear)
                ->where('status_bayar', 'LUNAS')
                ->pluck('siswa_id');

            $unpaidStudents = Siswa::where('status_siswa', 'AKTIF')
                ->whereNotIn('id', $paidSiswaIds)
                ->orderBy('nama_lengkap')
                ->limit(5)
                ->get();

            foreach ($unpaidStudents as $s) {
                $isLate = $now->day > 10;
                $title = $isLate ? 'Tagihan SPP Telat Bayar' : 'Tagihan SPP Jatuh Tempo';
                $color = $isLate ? '#dc2626' : '#f97316'; // Merah / Oranye

                $notifications[] = [
                    'id' => 'due_siswa_' . $s->id . '_' . $currentMonth,
                    'type' => 'pembayaran',
                    'title' => $title,
                    'message' => $s->nama_lengkap . ' (' . ($s->kelas ?: 'Siswa') . ') belum lunas bulan ' . $now->translatedFormat('F'),
                    'time' => $isLate ? 'Lewat Jatuh Tempo' : 'Jatuh Tempo',
                    'created_at' => $now->toIso8601String(),
                    'url' => url('/behindpelita/pembayarans'),
                    'color' => $color,
                    'icon' => 'cash',
                ];
            }
        }

        return response()->json([
            'items' => array_values($notifications),
            'unread_count' => count($notifications),
        ]);
    }
}
