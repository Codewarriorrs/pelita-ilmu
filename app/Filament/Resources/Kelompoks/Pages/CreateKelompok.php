<?php

namespace App\Filament\Resources\Kelompoks\Pages;

use App\Filament\Resources\Kelompoks\KelompokResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreateKelompok extends CreateRecord
{
    use HasSmartCancelAction;

    protected static string $resource = KelompokResource::class;
}
