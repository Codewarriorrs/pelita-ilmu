<?php

namespace App\Filament\Widgets;

use App\Models\JadwalKelompok;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;

class JadwalHariIniWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    // Poll setiap 60 detik — kurangi round-trip ke DB
    protected static ?string $pollingInterval = '60s';

    protected static ?string $heading = 'Jadwal Bimbingan Belajar Hari Ini';

    /**
     * Otorisasi: Dapat dilihat oleh Admin maupun Tentor yang login.
     */
    public static function canView(): bool
    {
        return auth()->check();
    }

    public function table(Table $table): Table
    {
        $hariIni = Carbon::today()->toDateString();

        return $table
            ->query(
                JadwalKelompok::query()
                    // 1. Filter hanya sesi bimbingan hari ini
                    ->whereDate('tanggal_sesi', $hariIni)
                    // 2. Eager Loading relasi untuk menghindari N+1 Query Problem
                    ->with([
                        'kelompok.tentor',
                        'kelompok.mapel',
                    ])
            )
            ->columns([
                TextColumn::make('kelompok.nama_kelompok')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->weight('bold'),

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
            ->emptyStateHeading('Tidak Ada Sesi Bimbingan Hari Ini')
            ->emptyStateDescription('Hari ini tidak ada jadwal kelompok belajar tatap muka yang terdaftar.')
            ->emptyStateIcon('heroicon-o-calendar-days')
            ->paginated([5, 10]);
    }
}
