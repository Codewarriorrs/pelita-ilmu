<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailPresensiResource\Pages;
use App\Models\DetailPresensi;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DetailPresensiResource extends Resource
{
    protected static ?string $model = DetailPresensi::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik';
    protected static ?string $navigationLabel = 'Rekap Presensi';
    protected static ?string $modelLabel = 'Presensi Siswa';
    protected static ?string $pluralModelLabel = 'Rekap Presensi Siswa';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jadwal_id')
                    ->label('Sesi Pertemuan')
                    ->relationship('jadwal', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->kelompok?->nama_kelompok} - " . ($record->tanggal_sesi?->format('d M Y') ?? ''))
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('siswa_id')
                    ->label('Nama Siswa')
                    ->relationship('siswa', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('status_kehadiran')
                    ->label('Status Kehadiran')
                    ->options([
                        'HADIR' => 'Hadir',
                        'IZIN'  => 'Izin',
                        'SAKIT' => 'Sakit',
                        'ALPA'  => 'Alpa',
                    ])
                    ->default('HADIR')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['jadwal.kelompok.mapel', 'jadwal.kelompok.tentor', 'siswa']))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('jadwal.tanggal_sesi')
                    ->label('Tanggal Sesi')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('jadwal.kelompok.nama_kelompok')
                    ->label('Kelompok Belajar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('jadwal.kelompok.mapel.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('siswa.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status_kehadiran')
                    ->label('Status Presensi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'HADIR' => 'success',
                        'IZIN'  => 'info',
                        'SAKIT' => 'warning',
                        'ALPA'  => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('jadwal.kelompok.tentor.name')
                    ->label('Tentor Pengampu')
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status_kehadiran')
                    ->label('Status Kehadiran')
                    ->options([
                        'HADIR' => 'Hadir',
                        'IZIN'  => 'Izin',
                        'SAKIT' => 'Sakit',
                        'ALPA'  => 'Alpa',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Rekapitulasi Presensi')
            ->emptyStateDescription('Presensi yang diisi tentor atau admin akan tercatat otomatis di sini.')
            ->emptyStateIcon('heroicon-o-clipboard-document-check');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetailPresensis::route('/'),
        ];
    }
}
