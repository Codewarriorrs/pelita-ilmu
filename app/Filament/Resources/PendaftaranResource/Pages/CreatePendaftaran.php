<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftaran extends CreateRecord
{
    use HasSmartCancelAction;

    protected static string $resource = PendaftaranResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
