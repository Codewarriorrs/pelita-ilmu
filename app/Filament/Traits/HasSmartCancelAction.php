<?php

namespace App\Filament\Traits;

use Filament\Actions\Action;

trait HasSmartCancelAction
{
    protected function getCancelFormAction(): Action
    {
        $resourceIndex = static::getResource()::getUrl('index');
        $previous = $this->previousUrl;

        // Cek path URL sebelumnya
        $path = $previous ? parse_url($previous, PHP_URL_PATH) : null;

        // Abaikan jika previous URL adalah dashboard /admin atau halaman form saat ini
        $isDashboard = $path && (rtrim($path, '/') === '/admin' || str_ends_with(rtrim($path, '/'), '/admin'));
        $isCurrent = $previous && (rtrim($previous, '/') === rtrim(url()->current(), '/'));

        // Jika ada previous URL yang valid (misal list jadwal / siswa / filter / rekap), kembali ke situ.
        // Jika dari dashboard atau tidak ada history, kembali ke halaman index tabel resource ini.
        $url = ($previous && ! $isDashboard && ! $isCurrent)
            ? $previous
            : $resourceIndex;

        return Action::make('cancel')
            ->label('Batal')
            ->url($url)
            ->color('gray');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
