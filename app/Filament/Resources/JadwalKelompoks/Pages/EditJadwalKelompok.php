<?php

namespace App\Filament\Resources\JadwalKelompoks\Pages;

use App\Filament\Resources\JadwalKelompoks\JadwalKelompokResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalKelompok extends EditRecord
{
    protected static string $resource = JadwalKelompokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
