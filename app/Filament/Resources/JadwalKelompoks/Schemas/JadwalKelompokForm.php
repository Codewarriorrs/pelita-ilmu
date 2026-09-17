<?php

namespace App\Filament\Resources\JadwalKelompoks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class JadwalKelompokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kelompok_id')
                    ->relationship('kelompok', 'id')
                    ->required(),
                DatePicker::make('tanggal_sesi')
                    ->required(),
            ]);
    }
}
