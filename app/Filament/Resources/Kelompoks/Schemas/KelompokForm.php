<?php

namespace App\Filament\Resources\Kelompoks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class KelompokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kelompok')
                    ->required(),
                Select::make('mapel_id')
                    ->relationship('mapel', 'id')
                    ->required(),
                Select::make('tentor_id')
                    ->relationship('tentor', 'name')
                    ->required(),
                TextInput::make('jadwal_hari'),
                TimePicker::make('jam_mulai'),
                TimePicker::make('jam_selesai'),
            ]);
    }
}
