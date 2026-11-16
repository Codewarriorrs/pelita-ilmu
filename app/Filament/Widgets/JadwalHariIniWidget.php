<?php

namespace App\Filament\Widgets;

use App\Models\JadwalKelompok;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class JadwalHariIniWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected ?string $pollingInterval = null;

    protected static ?string $heading = 'Jadwal Bimbingan Belajar';

    public static function canView(): bool
    {
        return auth()->check();
    }

    public function table(Table $table): Table
    {
        $query = JadwalKelompok::query()
            ->with([
                'kelompok.tentor',
                'kelompok.mapel',
            ]);

        return $table
            ->query($query)
            ->filters([
                SelectFilter::make('rentang_waktu')
                    ->label('Filter Waktu')
                    ->options([
                        'hari_ini' => 'Hari Ini',
                        'bulan_ini' => 'Bulan Ini',
                    ])
                    ->default('hari_ini')
                    ->selectablePlaceholder(false)
                    ->query(function (Builder $query, array $data) {
                        $value = !empty($data['value']) ? $data['value'] : 'hari_ini';
                        if ($value === 'bulan_ini') {
                            return $query->whereBetween('tanggal_sesi', [
                                Carbon::now()->startOfMonth()->toDateString(),
                                Carbon::now()->endOfMonth()->toDateString(),
                            ]);
                        }
                        return $query->whereDate('tanggal_sesi', Carbon::today()->toDateString());
                    }),
            ])
            ->columns([
                TextColumn::make('tanggal_sesi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('kelompok.nama_kelompok')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('ruang_kelas')
                    ->label('Ruangan')
                    ->badge()
                    ->color('info')
                    ->placeholder('-'),

                TextColumn::make('kelompok.mapel.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('kelompok.tentor.name')
                    ->label('Tentor Pengampu')
                    ->icon('heroicon-m-user')
                    ->color('gray'),

                TextColumn::make('jam_sesi')
                    ->label('Jam Pelaksanaan')
                    ->state(function (JadwalKelompok $record): string {
                        $mulai = $record->kelompok?->jam_mulai ? substr((string) $record->kelompok->jam_mulai, 0, 5) : '-';
                        $selesai = $record->kelompok?->jam_selesai ? substr((string) $record->kelompok->jam_selesai, 0, 5) : '-';
                        return "{$mulai} - {$selesai} WIB";
                    })
                    ->badge()
                    ->color('warning'),

                TextColumn::make('status_sesi')
                    ->label('Status Sesi')
                    ->default('Terjadwal')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'SELESAI' => 'success',
                        'BERJALAN' => 'warning',
                        'BATAL' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->emptyStateHeading('Tidak Ada Sesi Bimbingan')
            ->emptyStateDescription('Tidak ada jadwal kelompok belajar untuk periode yang dipilih.')
            ->emptyStateIcon('heroicon-o-calendar-days')
            ->paginated([5, 10]);
    }
}

