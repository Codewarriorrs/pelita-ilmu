<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    use HasSmartCancelAction;

    protected static string $resource = SiswaResource::class;
}
