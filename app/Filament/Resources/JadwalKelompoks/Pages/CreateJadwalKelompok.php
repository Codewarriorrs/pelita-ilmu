<?php

namespace App\Filament\Resources\JadwalKelompoks\Pages;

use App\Filament\Resources\JadwalKelompoks\JadwalKelompokResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalKelompok extends CreateRecord
{
    use HasSmartCancelAction;

    protected static string $resource = JadwalKelompokResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
