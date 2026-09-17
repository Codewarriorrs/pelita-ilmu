<?php

namespace App\Filament\Resources\Kelompoks;

use App\Filament\Resources\Kelompoks\Pages;
use App\Models\Kelompok;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KelompokResource extends Resource
{
    protected static ?string $model = Kelompok::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Kelompok Belajar';
    protected static ?string $modelLabel = 'Kelompok';
    protected static ?string $pluralModelLabel = 'Kelompok Belajar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kelompok')
                    ->label('Nama Kelompok')
                    ->required()
                    ->placeholder('Contoh: Reguler 10 SMA Mat-1')
                    ->maxLength(255),

                // 1. Relasi BelongsTo ke Mata Pelajaran
                Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->relationship('mapel', 'nama_mapel')
                    ->searchable()
                    ->preload()
                    ->required(),

                // 2. Relasi BelongsTo ke User (Hanya yang ber-role TENTOR)
                Select::make('tentor_id')
                    ->label('Tentor Pengampu')
                    ->relationship(
                        name: 'tentor',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('role', 'TENTOR')
                            ->orWhereHas('roles', fn ($q) => $q->where('name', 'TENTOR'))
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('jadwal_hari')
                    ->label('Jadwal Hari')
                    ->placeholder('Contoh: Senin & Rabu')
                    ->required(),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->required(),

                TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->required(),

                // 3. Relasi Many-to-Many ke Siswa (Tabel pemetaan_kelompok)
                Select::make('siswa')
                    ->label('Pilih Anggota Siswa')
                    ->relationship('siswa', 'nama_lengkap')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->helperText('Pilih siswa-siswa yang dimasukkan ke dalam kelompok ini.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with(['mapel', 'tentor', 'siswa', 'jadwalKelompok']))
            ->columns([
                TextColumn::make('nama_kelompok')
                    ->label('Kelompok')
                    ->searchable(isIndividual: false)
                    ->sortable(),

                TextColumn::make('mapel.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->sortable(),

                TextColumn::make('tentor.name')
                    ->label('Tentor')
                    ->sortable(),

                TextColumn::make('jadwal_hari')
                    ->label('Hari'),

                TextColumn::make('jam_mulai')
                    ->label('Jam')
                    ->formatStateUsing(fn ($record) => substr($record->jam_mulai, 0, 5) . ' - ' . substr($record->jam_selesai, 0, 5)),

                // Menghitung jumlah siswa dalam kelompok
                TextColumn::make('siswa_count')
                    ->counts('siswa')
                    ->label('Jml Siswa')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading('Belum Ada Data Kelompok');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelompoks::route('/'),
            'create' => Pages\CreateKelompok::route('/create'),
            'view' => Pages\ViewKelompok::route('/{record}'),
            'edit' => Pages\EditKelompok::route('/{record}/edit'),
        ];
    }
}