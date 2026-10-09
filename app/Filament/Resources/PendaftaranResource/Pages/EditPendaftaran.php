<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPendaftaran extends EditRecord
{
    use HasSmartCancelAction;

    protected static string $resource = PendaftaranResource::class;

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
