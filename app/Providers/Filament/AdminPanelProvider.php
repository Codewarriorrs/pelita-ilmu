<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\JadwalHariIniWidget;
use App\Filament\Widgets\SiswaJatuhTempoWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Pelita Ilmu Bimbel')
            ->brandLogo(asset('images/logo-bimbel.png'))
            ->brandLogoHeight('2.5rem')
            ->homeUrl('/')
            ->favicon(asset('images/logo-bimbel-removebg.png'))
            ->darkMode(false)
            ->font('Plus Jakarta Sans')
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn () => new \Illuminate\Support\HtmlString('
                    <link rel="icon" type="image/png" href="' . asset('images/logo-bimbel-removebg.png') . '">
                    <style>
                        /* Align table header title & search input inline on 1 horizontal row */
                        .fi-ta-header {
                            display: flex !important;
                            flex-direction: row !important;
                            align-items: center !important;
                            justify-content: space-between !important;
                            flex-wrap: nowrap !important;
                            gap: 1rem !important;
                            padding: 1.25rem 1.5rem !important;
                        }
                        .fi-ta-header-heading-group {
                            margin: 0 !important;
                            padding: 0 !important;
                        }
                        .fi-ta-header-heading {
                            font-size: 1.125rem !important;
                            font-weight: 800 !important;
                            color: #193836 !important;
                            margin: 0 !important;
                            white-space: nowrap !important;
                        }
                        .fi-ta-header-toolbar {
                            margin-top: 0 !important;
                            margin-left: auto !important;
                            display: flex !important;
                            align-items: center !important;
                            gap: 0.75rem !important;
                        }
                        .fi-ta-search-field, .fi-ta-search-field input {
                            border-radius: 0.75rem !important;
                        }

                        /* SOLID & BOLD STATUS BADGES (No soft/translucent opacity) */
                        .fi-badge {
                            font-weight: 800 !important;
                            font-size: 0.725rem !important;
                            padding: 0.25rem 0.65rem !important;
                            border-radius: 0.5rem !important;
                            letter-spacing: 0.04em !important;
                            text-transform: uppercase !important;
                            border: none !important;
                            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.12) !important;
                        }
                        .fi-badge span, .fi-badge div {
                            color: #ffffff !important;
                            font-weight: 800 !important;
                        }
                        /* Green / Hadir / Selesai */
                        .fi-badge-color-success, [class*="fi-badge-color-success"], .fi-color-success .fi-badge {
                            background-color: #16a34a !important;
                            color: #ffffff !important;
                        }
                        /* Red / Alpa / Batal / Menunggak */
                        .fi-badge-color-danger, [class*="fi-badge-color-danger"], .fi-color-danger .fi-badge {
                            background-color: #dc2626 !important;
                            color: #ffffff !important;
                        }
                        /* Yellow / Amber / Sakit / Terjadwal */
                        .fi-badge-color-warning, [class*="fi-badge-color-warning"], .fi-color-warning .fi-badge {
                            background-color: #d97706 !important;
                            color: #ffffff !important;
                        }
                        /* Blue / Izin */
                        .fi-badge-color-info, [class*="fi-badge-color-info"], .fi-color-info .fi-badge {
                            background-color: #2563eb !important;
                            color: #ffffff !important;
                        }
                        /* Primary / Teal */
                        .fi-badge-color-primary, [class*="fi-badge-color-primary"], .fi-color-primary .fi-badge {
                            background-color: #0f766e !important;
                            color: #ffffff !important;
                        }

                        /* Compact Icon Buttons */
                        .fi-icon-btn {
                            border-radius: 0.5rem !important;
                            transition: transform 0.15s ease !important;
                        }
                        .fi-icon-btn:hover {
                            transform: scale(1.1) !important;
                        }

                        /* Mobile Responsiveness for Data Tables */
                        @media (max-width: 768px) {
                            .fi-ta-header {
                                flex-direction: column !important;
                                align-items: stretch !important;
                            }
                            .fi-ta-header-toolbar {
                                margin-left: 0 !important;
                                width: 100% !important;
                                justify-content: space-between !important;
                            }
                            .fi-ta-content {
                                overflow-x: auto !important;
                                -webkit-overflow-scrolling: touch;
                            }
                        }
                    </style>
                ')
            )
            ->colors([
                'primary' => [
                    50 => '#e6f4f3',
                    100 => '#b3e0dc',
                    200 => '#80ccc5',
                    300 => '#4db8ae',
                    400 => '#26a99b',
                    500 => '#009688',
                    600 => '#00887a',
                    700 => '#007769',
                    800 => '#006558',
                    900 => '#00463b',
                    950 => '#193836',
                ],
                'gray' => Color::Slate,
                'warning' => [
                    50 => '#fefce8',
                    100 => '#fef9c3',
                    200 => '#fef08a',
                    300 => '#fde047',
                    400 => '#facc15',
                    500 => '#FFE500',
                    600 => '#ca8a04',
                    700 => '#a16207',
                    800 => '#854d0e',
                    900 => '#713f12',
                    950 => '#422006',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverviewWidget::class,
                SiswaJatuhTempoWidget::class,
                JadwalHariIniWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make());
    }
}
