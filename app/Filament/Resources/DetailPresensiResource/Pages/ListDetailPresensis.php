<?php

namespace App\Filament\Resources\DetailPresensiResource\Pages;

use App\Filament\Resources\DetailPresensiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetailPresensis extends ListRecords
{
    protected static string $resource = DetailPresensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Catat Presensi Siswa Baru'),
        ];
    }
}
