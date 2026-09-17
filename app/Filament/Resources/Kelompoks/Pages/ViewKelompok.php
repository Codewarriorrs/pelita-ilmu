<?php

namespace App\Filament\Resources\Kelompoks\Pages;

use App\Filament\Resources\Kelompoks\KelompokResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKelompok extends ViewRecord
{
    protected static string $resource = KelompokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
