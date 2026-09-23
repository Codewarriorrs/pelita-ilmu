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
                        /* ===== TABLE HEADER: Search + Title + Buttons di 1 Baris Sejajar ===== */
                        .fi-ta-header {
                            display: flex !important;
                            flex-direction: row !important;
                            align-items: center !important;
                            justify-content: space-between !important;
                            flex-wrap: wrap !important;
                            gap: 0.75rem !important;
                            padding: 1rem 1.25rem !important;
                        }
                        .fi-ta-header-heading-group {
                            margin: 0 !important;
                            padding: 0 !important;
                            flex-shrink: 0 !important;
                        }
                        .fi-ta-header-heading {
                            font-size: 1.05rem !important;
                            font-weight: 800 !important;
                            color: #193836 !important;
                            margin: 0 !important;
                            white-space: nowrap !important;
                        }
                        .fi-ta-header-toolbar, .fi-ta-actions {
                            margin-top: 0 !important;
                            margin-left: auto !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: flex-end !important;
                            gap: 0.5rem !important;
                            flex-wrap: nowrap !important;
                        }
                        /* Search field & Button perfect height & vertical centering */
                        .fi-ta-search-field {
                            margin: 0 !important;
                            align-self: center !important;
                        }
                        .fi-ta-search-field input {
                            border-radius: 0.75rem !important;
                            font-size: 0.8rem !important;
                            height: 2.25rem !important;
                            padding-top: 0 !important;
                            padding-bottom: 0 !important;
                        }
                        .fi-ta-header-toolbar button, .fi-ta-header-toolbar a, .fi-ta-header-toolbar .fi-icon-btn {
                            align-self: center !important;
                            margin: 0 !important;
                        }

                        /* ===== SOLID & BOLD STATUS BADGES ===== */
                        .fi-badge {
                            font-weight: 800 !important;
                            font-size: 0.7rem !important;
                            padding: 0.2rem 0.6rem !important;
                            border-radius: 0.45rem !important;
                            letter-spacing: 0.03em !important;
                            text-transform: uppercase !important;
                            border: none !important;
                            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.15) !important;
                        }
                        .fi-badge span, .fi-badge div { color: #ffffff !important; font-weight: 800 !important; }
                        .fi-badge-color-success, [class*="fi-badge-color-success"] { background-color: #16a34a !important; color: #ffffff !important; }
                        .fi-badge-color-danger,  [class*="fi-badge-color-danger"]  { background-color: #dc2626 !important; color: #ffffff !important; }
                        .fi-badge-color-warning, [class*="fi-badge-color-warning"] { background-color: #d97706 !important; color: #ffffff !important; }
                        .fi-badge-color-info,    [class*="fi-badge-color-info"]    { background-color: #2563eb !important; color: #ffffff !important; }
                        .fi-badge-color-primary, [class*="fi-badge-color-primary"] { background-color: #0f766e !important; color: #ffffff !important; }
                        .fi-badge-color-gray,    [class*="fi-badge-color-gray"]    { background-color: #475569 !important; color: #ffffff !important; }

                        /* ===== ICON BUTTONS ===== */
                        .fi-icon-btn { border-radius: 0.5rem !important; transition: transform 0.15s ease !important; }
                        .fi-icon-btn:hover { transform: scale(1.12) !important; }

                        /* ===== DASHBOARD STATS CARD: More Premium ===== */
                        .fi-wi-stats-overview-stat {
                            border-radius: 1rem !important;
                            border: 1.5px solid rgba(25,56,54,0.1) !important;
                            box-shadow: 0 4px 16px -2px rgba(0,150,136,0.10), 0 1px 4px -1px rgba(0,0,0,0.06) !important;
                            transition: box-shadow 0.2s, transform 0.2s !important;
                            background: linear-gradient(135deg, #fff 70%, #e6f4f3 100%) !important;
                        }
                        .fi-wi-stats-overview-stat:hover {
                            box-shadow: 0 8px 24px -4px rgba(0,150,136,0.18), 0 2px 8px -1px rgba(0,0,0,0.08) !important;
                            transform: translateY(-2px) !important;
                        }
                        .fi-wi-stats-overview-stat-value {
                            font-weight: 900 !important;
                            font-size: 1.7rem !important;
                            color: #193836 !important;
                        }
                        .fi-wi-stats-overview-stat-description {
                            font-size: 0.78rem !important;
                            color: #64748b !important;
                        }

                        /* ===== SIDEBAR: Style Premium ===== */
                        .fi-sidebar-nav-group-label {
                            font-size: 0.65rem !important;
                            font-weight: 700 !important;
                            letter-spacing: 0.1em !important;
                            text-transform: uppercase !important;
                            color: #94a3b8 !important;
                            padding: 0.5rem 0.75rem 0.2rem !important;
                        }
                        .fi-sidebar-item-button {
                            border-radius: 0.6rem !important;
                            transition: background 0.15s, color 0.15s !important;
                        }
                        .fi-sidebar-item-button:hover { background: rgba(0,150,136,0.08) !important; }
                        .fi-sidebar-item-active .fi-sidebar-item-button {
                            background: linear-gradient(90deg, rgba(0,150,136,0.15) 0%, rgba(0,150,136,0.05) 100%) !important;
                            border-left: 3px solid #009688 !important;
                        }

                        /* ===== WIDGET TABLE: Card style ===== */
                        .fi-ta-wrp {
                            border-radius: 1rem !important;
                            overflow: hidden !important;
                            border: 1.5px solid rgba(25,56,54,0.08) !important;
                            box-shadow: 0 2px 12px -2px rgba(0,0,0,0.07) !important;
                        }

                        /* ===== MOBILE RESPONSIVE CARDS FOR DASHBOARD TABLES ===== */
                        @media (max-width: 768px) {
                            .fi-ta-header { flex-direction: column !important; align-items: stretch !important; }
                            .fi-ta-header-toolbar { margin-left: 0 !important; width: 100% !important; justify-content: space-between !important; }
                            
                            /* Transform Filament Table Rows to Mobile Cards */
                            .fi-ta-table { display: block !important; width: 100% !important; }
                            .fi-ta-table > thead { display: none !important; }
                            .fi-ta-table > tbody { display: flex !important; flex-direction: column !important; gap: 0.85rem !important; padding: 0.75rem 0.5rem !important; }
                            .fi-ta-table > tbody > tr {
                                display: flex !important;
                                flex-direction: column !important;
                                background: #ffffff !important;
                                border: 1.5px solid #cbd5e1 !important;
                                border-radius: 1rem !important;
                                padding: 1rem !important;
                                box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.06) !important;
                            }
                            .fi-ta-table > tbody > tr > td {
                                display: flex !important;
                                align-items: center !important;
                                justify-content: space-between !important;
                                padding: 0.45rem 0 !important;
                                border-bottom: 1px dashed #e2e8f0 !important;
                                font-size: 0.85rem !important;
                            }
                            .fi-ta-table > tbody > tr > td:last-child {
                                border-bottom: none !important;
                                padding-top: 0.75rem !important;
                                justify-content: flex-end !important;
                                gap: 0.5rem !important;
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
