<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use App\Filament\Resources\PembayaranResource\Widgets\PembayaranOverviewWidget;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPembayarans extends ListRecords
{
    use ExposesTableToWidgets {
        getWidgetData as protected getBaseWidgetData;
    }

    protected static string $resource = PembayaranResource::class;

    public string $lastSyncedPeriode = 'BULAN';

    public string $lastSyncedBulan = '';

    public function mount(): void
    {
        parent::mount();

        $this->lastSyncedPeriode = $this->getActivePeriodeWaktu();
        $this->lastSyncedBulan = $this->getActiveBulanRaw();
    }

    public function updatedTableFilters(mixed $value = null, ?string $key = null): void
    {
        $periode = (string) ($this->tableFilters['periode_waktu']['value'] ?? 'BULAN');
        $bulan = (string) ($this->tableFilters['untuk_bulan']['value'] ?? (int) now()->month);

        $periodeChanged = ($key === 'periode_waktu.value')
            || str_starts_with((string) $key, 'periode_waktu')
            || ($key === null && $periode !== $this->lastSyncedPeriode);

        $bulanChanged = ($key === 'untuk_bulan.value')
            || str_starts_with((string) $key, 'untuk_bulan')
            || ($key === null && $bulan !== $this->lastSyncedBulan);

        if ($periodeChanged && in_array($periode, ['HARI_INI', 'MINGGU_INI', 'SEMUA'], true)) {
            $this->tableFilters['untuk_bulan']['value'] = 'ALL';
        } elseif ($bulanChanged && is_numeric($bulan) && (int) $bulan >= 1 && (int) $bulan <= 12) {
            $this->tableFilters['periode_waktu']['value'] = 'BULAN';
        }

        $this->lastSyncedPeriode = (string) ($this->tableFilters['periode_waktu']['value'] ?? 'BULAN');
        $this->lastSyncedBulan = (string) ($this->tableFilters['untuk_bulan']['value'] ?? 'ALL');

        parent::updatedTableFilters();
    }

    public function getWidgetData(): array
    {
        $data = $this->getBaseWidgetData();

        return [
            ...$data,
            'tableColumnSearches' => is_array($data['tableColumnSearches'] ?? null) ? $data['tableColumnSearches'] : [],
            'tableFilters' => is_array($data['tableFilters'] ?? null) ? $data['tableFilters'] : [],
        ];
    }

    public function getActivePeriodeWaktu(): string
    {
        $value = $this->getTableFilterState('periode_waktu')['value'] ?? null;

        return (filled($value) && in_array((string) $value, ['BULAN', 'HARI_INI', 'MINGGU_INI', 'SEMUA'], true))
            ? (string) $value
            : 'BULAN';
    }

    public function getActiveBulanRaw(): string
    {
        $value = $this->getTableFilterState('untuk_bulan')['value'] ?? null;

        return filled($value) ? (string) $value : (string) (int) now()->month;
    }

    public function getActiveBulan(): ?int
    {
        $raw = $this->getActiveBulanRaw();

        if ($raw === 'ALL' || ! is_numeric($raw)) {
            return null;
        }

        $int = (int) $raw;

        return ($int >= 1 && $int <= 12) ? $int : null;
    }

    public function getActiveTahun(): int
    {
        $value = $this->getTableFilterState('untuk_tahun')['value'] ?? null;

        return (filled($value) && is_numeric($value)) ? (int) $value : (int) now()->year;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Catat Pembayaran Baru'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PembayaranOverviewWidget::class,
        ];
    }
}
