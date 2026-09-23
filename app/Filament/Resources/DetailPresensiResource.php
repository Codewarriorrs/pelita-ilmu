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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class DetailPresensiResource extends Resource
{
    protected static ?string $model = DetailPresensi::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik';
    protected static ?string $navigationLabel = 'Log Presensi';
    protected static ?string $modelLabel = 'Presensi Siswa';
    protected static ?string $pluralModelLabel = 'Rekap Presensi Siswa';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false;

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
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->select('detail_presensi.*')
                ->leftJoin('jadwal_kelompok', 'detail_presensi.jadwal_id', '=', 'jadwal_kelompok.id')
                ->leftJoin('kelompok', 'jadwal_kelompok.kelompok_id', '=', 'kelompok.id')
                ->leftJoin('siswa', 'detail_presensi.siswa_id', '=', 'siswa.id')
                ->with(['jadwal.kelompok.mapel', 'jadwal.kelompok.tentor', 'siswa'])
            )
            ->defaultSort('jadwal_kelompok.tanggal_sesi', 'desc')
            ->columns([
                TextColumn::make('jadwal.tanggal_sesi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('jadwal_kelompok.tanggal_sesi', $direction))
                    ->weight('semibold'),

                TextColumn::make('hari_sesi')
                    ->label('Hari')
                    ->state(fn ($record) => $record->jadwal?->tanggal_sesi ? \Carbon\Carbon::parse($record->jadwal->tanggal_sesi)->locale('id')->isoFormat('dddd') : '-')
                    ->color('gray'),

                TextColumn::make('siswa.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('siswa.nama_lengkap', $direction))
                    ->weight('bold'),

                TextColumn::make('jadwal.kelompok.nama_kelompok')
                    ->label('Kelompok Belajar')
                    ->searchable()
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('kelompok.nama_kelompok', $direction)),

                TextColumn::make('jadwal.kelompok.mapel.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('status_kehadiran')
                    ->label('Kehadiran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'HADIR' => 'success',
                        'IZIN'  => 'info',
                        'SAKIT' => 'warning',
                        'ALPA'  => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('jadwal.kelompok.tentor.name')
                    ->label('Tentor Pengajar')
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '1'  => 'Januari',  '2'  => 'Februari', '3'  => 'Maret',
                        '4'  => 'April',    '5'  => 'Mei',       '6'  => 'Juni',
                        '7'  => 'Juli',     '8'  => 'Agustus',  '9'  => 'September',
                        '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',
                    ])
                    ->default((string) now()->month)
                    ->query(fn (Builder $query, array $data) =>
                        $query->when($data['value'], fn ($q, $val) =>
                            $q->whereRaw('extract(month from jadwal_kelompok.tanggal_sesi) = ?', [(int)$val])
                        )
                    ),

                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(collect(range(now()->year, now()->year - 2))->mapWithKeys(fn ($y) => [(string) $y => (string) $y])->all())
                    ->default((string) now()->year)
                    ->query(fn (Builder $query, array $data) =>
                        $query->when($data['value'], fn ($q, $val) =>
                            $q->whereRaw('extract(year from jadwal_kelompok.tanggal_sesi) = ?', [(int)$val])
                        )
                    ),

                SelectFilter::make('status_kehadiran')
                    ->label('Status Kehadiran')
                    ->options([
                        'HADIR' => 'Hadir',
                        'IZIN'  => 'Izin',
                        'SAKIT' => 'Sakit',
                        'ALPA'  => 'Alpa',
                    ]),
            ])
            ->filtersFormColumns(3)
            ->actions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
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
