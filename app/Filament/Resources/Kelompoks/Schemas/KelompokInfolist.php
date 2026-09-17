<?php

namespace App\Filament\Resources\Kelompoks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class KelompokInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_kelompok'),
                TextEntry::make('mapel.id')
                    ->label('Mapel'),
                TextEntry::make('tentor.name')
                    ->label('Tentor'),
                TextEntry::make('jadwal_hari')
                    ->placeholder('-'),
                TextEntry::make('jam_mulai')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('jam_selesai')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
