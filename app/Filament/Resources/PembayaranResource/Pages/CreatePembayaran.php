<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePembayaran extends CreateRecord
{
    protected static string $resource = PembayaranResource::class;

    public function mount(): void
    {
        parent::mount();

        $siswaId = request()->query('siswa_id');
        if ($siswaId) {
            $siswa = \App\Models\Siswa::find($siswaId);
            if ($siswa) {
                $this->form->fill([
                    'siswa_id' => $siswa->id,
                    'biaya_dibayar' => $siswa->biaya_bulanan,
                    'admin_pencatat_id' => auth()->id(),
                    'status_bayar' => 'LUNAS',
                    'metode_bayar' => 'TUNAI',
                    'tanggal_bayar' => now(),
                    'untuk_bulan' => (int) date('m'),
                    'untuk_tahun' => (int) date('Y'),
                ]);
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
