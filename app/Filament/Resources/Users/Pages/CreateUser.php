<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Traits\HasSmartCancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use HasSmartCancelAction;

    protected static string $resource = UserResource::class;
}
