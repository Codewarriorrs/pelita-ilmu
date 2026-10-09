<?php

namespace App\Filament\Resources\MataPelajarans\Pages;

use App\Filament\Resources\MataPelajarans\MataPelajaranResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreateMataPelajaran extends CreateRecord
{
    use HasSmartCancelAction;

    protected static string $resource = MataPelajaranResource::class;
}
