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
        $adminId = auth()->id() ?? User::where('role', 'ADMIN')->first()?->id ?? 1;

        $activeSiswa = Siswa::where('status_siswa', 'AKTIF')->get();
        $createdCount = 0;

        foreach ($activeSiswa as $siswa) {
            $exists = Pembayaran::where('siswa_id', $siswa->id)
                ->where('untuk_bulan', $bulan)
                ->where('untuk_tahun', $tahun)
                ->exists();

            if (!$exists) {
                Pembayaran::create([
                    'siswa_id' => $siswa->id,
                    'admin_pencatat_id' => $adminId,
                    'biaya_dibayar' => 0,
                    'metode_bayar' => 'TUNAI',
                    'status_bayar' => 'BELUM',
                    'tanggal_bayar' => null,
                    'untuk_bulan' => $bulan,
                    'untuk_tahun' => $tahun,
                ]);
                $createdCount++;
            }
        }

        return $createdCount;
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
}
