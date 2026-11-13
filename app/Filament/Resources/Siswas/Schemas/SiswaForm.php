<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
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
                Select::make('tipe_belajar')
                    ->options([
                        'KELOMPOK' => 'Kelompok',
                        'PRIVAT' => 'Privat',
                    ])
                    ->required()
                    ->default('KELOMPOK'),
                Select::make('tipe_jatuh_tempo')
                    ->options([
                        'AWAL BULAN' => 'Jatuh Tempo Awal Bulan',
                        'AKHIR BULAN' => 'Jatuh Tempo Akhir Bulan',
                    ])
                    ->required()
                    ->default('AWAL BULAN'),
                Select::make('status_siswa')
                    ->options([
                        'CALON' => 'Calon',
                        'BELUM_MULAI' => 'Belum Mulai',
                        'AKTIF' => 'Aktif',
                        'NONAKTIF' => 'Nonaktif',
                    ])
                    ->required()
                    ->default('CALON')
                    ->live()
                    ->afterStateUpdated(function (mixed $state, callable $set, callable $get): void {
                        if ($state === 'NONAKTIF' && blank($get('tanggal_keluar'))) {
                            $set('tanggal_keluar', now()->toDateString());
                        }
                    }),
                DatePicker::make('tanggal_keluar')
                    ->label('Tanggal Keluar / Berhenti')
                    ->visible(fn (Get $get): bool => $get('status_siswa') === 'NONAKTIF')
                    ->helperText('Tanggal siswa resmi mengundurkan diri atau selesai masa bimbingan.')
                    ->default(null),
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
