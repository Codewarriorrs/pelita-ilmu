<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_lengkap'),
                TextEntry::make('asal_sekolah')
                    ->placeholder('-'),
                TextEntry::make('kategori_kelas')
                    ->placeholder('-'),
                TextEntry::make('tipe_belajar'),
                TextEntry::make('tipe_jatuh_tempo'),
                TextEntry::make('status_siswa'),
                TextEntry::make('tanggal_daftar')
                    ->dateTime(),
                TextEntry::make('tanggal_lahir')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('alamat_rumah')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('no_telp_siswa')
                    ->placeholder('-'),
                TextEntry::make('nama_ortu')
                    ->placeholder('-'),
                TextEntry::make('no_telp_ortu')
                    ->placeholder('-'),
                TextEntry::make('biaya_bulanan')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
