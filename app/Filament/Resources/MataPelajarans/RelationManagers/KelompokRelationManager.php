<?php

namespace App\Filament\Resources\MataPelajarans\RelationManagers;

use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelompokRelationManager extends RelationManager
{
    protected static string $relationship = 'kelompok';

    protected static ?string $title = 'Kelompok Belajar untuk Mata Pelajaran Ini';

    protected static ?string $recordTitleAttribute = 'nama_kelompok';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kelompok')
                    ->label('Nama Kelompok')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: KELAS 10 FISIKA 1'),

                Select::make('tentor_id')
                    ->label('Tentor Pengampu')
                    ->options(User::where('role', 'TENTOR')->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('jadwal_hari')
                    ->label('Hari Belajar')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                        'Senin & Rabu' => 'Senin & Rabu',
                        'Selasa & Kamis' => 'Selasa & Kamis',
                        'Rabu & Jumat' => 'Rabu & Jumat',
                        'Senin & Kamis' => 'Senin & Kamis',
                        'Selasa & Jumat' => 'Selasa & Jumat',
                    ])
                    ->required(),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->required()
                    ->seconds(false),

                TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->required()
                    ->seconds(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kelompok')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('tentor.name')
                    ->label('Tentor Pengampu')
                    ->searchable()
                    ->placeholder('Belum Ditentukan'),

                TextColumn::make('jadwal_hari')
                    ->label('Hari')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('jam_mulai')
                    ->label('Jam')
                    ->formatStateUsing(fn ($record) => substr($record->jam_mulai, 0, 5) . ' - ' . substr($record->jam_selesai, 0, 5)),

                TextColumn::make('siswa_count')
                    ->counts('siswa')
                    ->label('Jml Siswa')
                    ->alignCenter(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Kelompok Baru'),
            ])
            ->actions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ]);
    }
}
