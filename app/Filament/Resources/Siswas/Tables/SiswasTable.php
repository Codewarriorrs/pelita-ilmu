<?php

namespace App\Filament\Resources\Siswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('asal_sekolah')
                    ->searchable(),
                TextColumn::make('kategori_kelas')
                    ->searchable(),
                TextColumn::make('tipe_belajar')
                    ->searchable(),
                TextColumn::make('tipe_jatuh_tempo')
                    ->searchable(),
                TextColumn::make('status_siswa')
                    ->searchable(),
                TextColumn::make('tanggal_daftar')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                TextColumn::make('no_telp_siswa')
                    ->searchable(),
                TextColumn::make('nama_ortu')
                    ->searchable(),
                TextColumn::make('no_telp_ortu')
                    ->searchable(),
                TextColumn::make('biaya_bulanan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
