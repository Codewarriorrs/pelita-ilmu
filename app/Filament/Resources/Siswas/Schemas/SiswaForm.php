<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lengkap')
                    ->required(),
                TextInput::make('asal_sekolah'),
                TextInput::make('kategori_kelas'),
                TextInput::make('tipe_belajar')
                    ->required()
                    ->default('KELOMPOK'),
                TextInput::make('tipe_jatuh_tempo')
                    ->required()
                    ->default('AWAL BULAN'),
                TextInput::make('status_siswa')
                    ->required()
                    ->default('CALON'),
                DateTimePicker::make('tanggal_daftar')
                    ->required(),
                DatePicker::make('tanggal_lahir'),
                Textarea::make('alamat_rumah')
                    ->columnSpanFull(),
                TextInput::make('no_telp_siswa')
                    ->tel(),
                TextInput::make('nama_ortu'),
                TextInput::make('no_telp_ortu')
                    ->tel(),
                TextInput::make('biaya_bulanan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
