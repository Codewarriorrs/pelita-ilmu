<?php

namespace App\Filament\Resources\JadwalKelompoks\Pages;

use App\Filament\Resources\JadwalKelompoks\JadwalKelompokResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJadwalKelompoks extends ListRecords
{
    protected static string $resource = JadwalKelompokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Jadwal Sesi Baru'),
        ];
    }
}
