<?php

namespace App\Filament\Resources\JadwalKelompoks\Pages;

use App\Filament\Resources\JadwalKelompoks\JadwalKelompokResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalKelompok extends EditRecord
{
    use HasSmartCancelAction;

    protected static string $resource = JadwalKelompokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
