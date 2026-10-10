<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPembayarans extends ListRecords
{
    protected static string $resource = PembayaranResource::class;

    public function mount(): void
    {
        parent::mount();
        $this->sinkronkanDataSiswaBulanIni();
    }

    public function sinkronkanDataSiswaBulanIni(?int $bulan = null, ?int $tahun = null): int
    {
        $bulan = $bulan ?? (int) date('m');
        $tahun = $tahun ?? (int) date('Y');
        $adminId = auth()->id() ?? User::where('role', 'ADMIN')->value('id') ?? 1;

        // Ambil ID siswa yang sudah memiliki data pembayaran di bulan ini dalam 1 query
        $existingSiswaIds = Pembayaran::where('untuk_bulan', $bulan)
            ->where('untuk_tahun', $tahun)
            ->pluck('siswa_id')
            ->flip()
            ->all();

        $activeSiswa = Siswa::where('status_siswa', 'AKTIF')->get(['id']);
        $toInsert = [];
        $now = now();

        foreach ($activeSiswa as $siswa) {
            if (! isset($existingSiswaIds[$siswa->id])) {
                $toInsert[] = [
                    'siswa_id' => $siswa->id,
                    'admin_pencatat_id' => $adminId,
                    'biaya_dibayar' => 0,
                    'metode_bayar' => 'TUNAI',
                    'status_bayar' => 'BELUM',
                    'tanggal_bayar' => null,
                    'untuk_bulan' => $bulan,
                    'untuk_tahun' => $tahun,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (! empty($toInsert)) {
            Pembayaran::insert($toInsert);
        }

        return count($toInsert);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sinkronkan_siswa')
                ->label('Sinkronkan Semua Siswa')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->tooltip('Pastikan seluruh siswa aktif tercatat di rekap pembayaran bulan ini')
                ->action(function () {
                    $count = $this->sinkronkanDataSiswaBulanIni();
                    Notification::make()
                        ->title("Sinkronisasi Selesai")
                        ->body("Data {$count} siswa aktif berhasil disinkronkan ke rekap pembayaran.")
                        ->success()
                        ->send();
                }),
            CreateAction::make()->label('Catat Pembayaran Baru'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\PembayaranResource\Widgets\PembayaranOverviewWidget::class,
        ];
    }
}
