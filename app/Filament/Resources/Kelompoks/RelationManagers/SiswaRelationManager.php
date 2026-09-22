<?php

namespace App\Filament\Resources\Kelompoks\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiswaRelationManager extends RelationManager
{
    protected static string $relationship = 'siswa';

    protected static ?string $title = 'Daftar Siswa Anggota Kelompok Ini';

    protected static ?string $recordTitleAttribute = 'nama_lengkap';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable(),

                TextColumn::make('kategori_kelas')
                    ->label('Kelas / Jenjang'),

                TextColumn::make('no_telp_siswa')
                    ->label('No. Telp Siswa')
                    ->icon('heroicon-m-phone'),

                TextColumn::make('no_telp_ortu')
                    ->label('No. Telp Orang Tua')
                    ->icon('heroicon-m-phone'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Tambah Siswa ke Kelompok Ini')
                    ->preloadRecordSelect(),
            ])
            ->actions([
                DetachAction::make()
                    ->label('Keluarkan dari Kelompok'),
            ])
            ->emptyStateHeading('Belum Ada Siswa di Kelompok Ini')
            ->emptyStateDescription('Klik "Tambah Siswa ke Kelompok Ini" untuk mendaftarkan siswa.')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
