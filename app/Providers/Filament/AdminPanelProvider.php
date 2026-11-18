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
            ->path('behindpelita')
            ->login()
            ->brandName('Pelita Ilmu Bimbel')
            ->brandLogo(asset('images/logo-bimbel.png'))
            ->brandLogoHeight('6rem')
            ->homeUrl('/')
            ->favicon(asset('images/logo-bimbel-removebg.png'))
            ->darkMode(false)
            ->font('Plus Jakarta Sans')
            ->globalSearch(\App\Filament\GlobalSearch\ComprehensiveGlobalSearchProvider::class)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->renderHook(
                \Filament\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn () => view('filament.components.notification-bell'),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_END,
                fn () => view('filament.components.onboarding-tour'),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::SIDEBAR_FOOTER,
                fn () => view('filament.components.sidebar-logout'),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn () => new \Illuminate\Support\HtmlString('
                    <link rel="icon" type="image/png" href="' . asset('images/logo-bimbel-removebg.png') . '">
                    <style>
                        /* ===== LOGIN PAGE BRAND LOGO (6rem) ===== */
                        .fi-simple-layout .fi-logo,
                        .fi-simple-main .fi-logo,
                        .fi-simple-header .fi-logo,
                        .fi-simple-page .fi-logo,
                        .fi-simple-layout img.fi-logo,
                        .fi-simple-main img.fi-logo,
                        .fi-simple-header img.fi-logo,
                        .fi-simple-header .fi-logo img {
                            height: 6rem !important;
                            max-height: 6rem !important;
                            width: auto !important;
                            max-width: 100% !important;
                            object-fit: contain !important;
                            margin: 0 auto !important;
                            display: block !important;
                        }

                        /* ===== SIDEBAR Z-INDEX FIX (Mencegah elemen tabel bocor di mobile) ===== */
                        .fi-sidebar {
                            z-index: 9999 !important;
                        }
                        .fi-sidebar-close-overlay {
                            z-index: 9998 !important;
                        }

                        /* ===== TOPBAR / NAVBAR: Putih Gradasi Hijau Tosca + Aksen Kuning + Hijau Gelap ===== */
                        .fi-topbar {
                            background: linear-gradient(90deg, #ffffff 0%, #f0fdfa 45%, #e6f4f3 100%) !important;
                            border-bottom: 2.5px solid #FFE500 !important;
                            box-shadow: 0 2px 10px rgba(25, 56, 54, 0.06) !important;
                        }
                        .fi-topbar nav,
                        .fi-topbar header {
                            background: transparent !important;
                        }
                        .fi-topbar .fi-icon-btn,
                        .fi-topbar button,
                        .fi-topbar svg {
                            color: #193836 !important;
                        }
                        .fi-topbar .fi-topbar-item {
                            color: #193836 !important;
                        }
                        /* ===== TOPBAR SEARCH BAR: Clean, Minimalis, Modern, Perfectly Aligned ===== */
                        .fi-topbar .fi-global-search-ctn {
                            display: flex !important;
                            align-items: center !important;
                        }
                        .fi-topbar .fi-global-search {
                            position: relative !important;
                            display: flex !important;
                            align-items: center !important;
                            width: 100% !important;
                            max-width: 280px !important;
                        }
                        .fi-topbar .fi-global-search-field {
                            position: relative !important;
                            width: 100% !important;
                            display: flex !important;
                            align-items: center !important;
                        }
                        .fi-topbar .fi-global-search-field .fi-input-wrp {
                            position: relative !important;
                            display: flex !important;
                            align-items: center !important;
                            background-color: #f8fafc !important;
                            border: 1px solid #e2e8f0 !important;
                            border-radius: 0.5rem !important;
                            height: 36px !important;
                            min-height: 36px !important;
                            max-height: 36px !important;
                            width: 100% !important;
                            padding: 0 !important;
                            box-shadow: none !important;
                            outline: none !important;
                            transition: all 0.15s ease-in-out !important;
                            --tw-ring-color: transparent !important;
                            --tw-ring-shadow: none !important;
                        }
                        .fi-topbar .fi-global-search-field .fi-input-wrp:hover {
                            background-color: #ffffff !important;
                            border-color: #cbd5e1 !important;
                        }
                        .fi-topbar .fi-global-search-field .fi-input-wrp:focus-within {
                            background-color: #ffffff !important;
                            border-color: #0f766e !important;
                            box-shadow: 0 0 0 1px #0f766e !important;
                        }
                        /* Kontainer prefix & ikon search: Center vertical, padding proporsional */
                        .fi-topbar .fi-global-search-field .fi-input-wrp-prefix {
                            position: absolute !important;
                            left: 0.65rem !important;
                            top: 50% !important;
                            transform: translateY(-50%) !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            padding: 0 !important;
                            margin: 0 !important;
                            border: none !important;
                            pointer-events: none !important;
                            z-index: 5 !important;
                            color: #94a3b8 !important;
                        }
                        .fi-topbar .fi-global-search-field .fi-input-wrp:focus-within .fi-input-wrp-prefix {
                            color: #0f766e !important;
                        }
                        .fi-topbar .fi-global-search-field .fi-input-wrp-prefix svg,
                        .fi-topbar .fi-global-search-field .fi-input-wrp > svg {
                            width: 15px !important;
                            height: 15px !important;
                            color: inherit !important;
                        }
                        .fi-topbar .fi-global-search-field .fi-input-wrp-content-ctn {
                            width: 100% !important;
                            height: 100% !important;
                            display: flex !important;
                            align-items: center !important;
                        }
                        /* Input text field: Jarak proporsional dari ikon ke placeholder */
                        .fi-topbar .fi-global-search-field input.fi-input {
                            width: 100% !important;
                            height: 100% !important;
                            border: none !important;
                            outline: none !important;
                            background: transparent !important;
                            padding-left: 2rem !important;
                            padding-right: 0.75rem !important;
                            padding-top: 0 !important;
                            padding-bottom: 0 !important;
                            line-height: 36px !important;
                            font-size: 0.8125rem !important;
                            color: #1e293b !important;
                            font-weight: 450 !important;
                            box-shadow: none !important;
                            --tw-ring-shadow: none !important;
                            --tw-ring-color: transparent !important;
                            border-radius: 0.5rem !important;
                        }
                        .fi-topbar .fi-global-search-field input.fi-input::placeholder {
                            color: #94a3b8 !important;
                            font-size: 0.8125rem !important;
                            font-weight: 400 !important;
                        }

                        /* Dropdown Hasil Pencarian Global (Selalu dropdown ke bawah input field) */
                        .fi-topbar .fi-global-search-results-ctn {
                            position: absolute !important;
                            top: calc(100% + 0.5rem) !important;
                            left: 0 !important;
                            right: auto !important;
                            bottom: auto !important;
                            width: 380px !important;
                            max-width: 90vw !important;
                            max-height: 420px !important;
                            overflow-y: auto !important;
                            z-index: 9999 !important;
                            border-radius: 0.75rem !important;
                            background: #ffffff !important;
                            border: 1px solid #e2e8f0 !important;
                            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
                        }
                        @media (max-width: 640px) {
                            .fi-topbar .fi-global-search-results-ctn {
                                width: calc(100vw - 2rem) !important;
                                left: 50% !important;
                                transform: translateX(-50%) !important;
                            }
                        }

                        .fi-topbar .pelita-bell-btn {
                            color: #193836 !important;
                        }
                        .fi-topbar .pelita-bell-btn:hover {
                            color: #0f766e !important;
                        }

                        /* ===== CHOICES / MULTI-SELECT BADGES (Solid Hijau #0f766e, Kontras Jelas) ===== */
                        .choices__list--multiple .choices__item,
                        .fi-fo-select .choices__list--multiple .choices__item,
                        .fi-select-input-badge,
                        .fi-fo-tags-entry-badge {
                            background-color: #0f766e !important;
                            border: 1px solid #0f766e !important;
                            color: #ffffff !important;
                            font-weight: 700 !important;
                            border-radius: 0.375rem !important;
                            padding: 0.25rem 0.5rem !important;
                        }
                        .choices__list--multiple .choices__item button,
                        .choices__list--multiple .choices__item .choices__button {
                            border-left: 1px solid rgba(255, 255, 255, 0.4) !important;
                            color: #ffffff !important;
                        }

                        /* ===== SIDEBAR / TOPBAR BRAND LOGO (Diperbesar) ===== */
                        .fi-sidebar-header .fi-logo,
                        .fi-sidebar-header img.fi-logo,
                        .fi-topbar .fi-logo,
                        .fi-topbar img.fi-logo {
                            height: 3.35rem !important;
                            max-height: 3.35rem !important;
                            width: auto !important;
                            object-fit: contain !important;
                        }

                        /* ===== TABLE HEADER: Search + Title + Buttons di 1 Baris Sejajar ===== */
                        .fi-ta-header-ctn {
                            display: flex !important;
                            flex-direction: row !important;
                            align-items: center !important;
                            justify-content: space-between !important;
                            flex-wrap: wrap !important;
                            gap: 0.75rem !important;
                            padding: 0.85rem 1.25rem !important;
                            border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
                        }
                        .fi-ta-header {
                            display: flex !important;
                            flex-direction: row !important;
                            align-items: center !important;
                            padding: 0 !important;
                            margin: 0 !important;
                            border: none !important;
                            box-shadow: none !important;
                            flex-grow: 1 !important;
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
                        .fi-ta-header-toolbar {
                            margin: 0 !important;
                            margin-left: auto !important;
                            padding: 0 !important;
                            border: none !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: flex-end !important;
                            gap: 0.5rem !important;
                            flex-wrap: nowrap !important;
                        }
                        .fi-ta-actions {
                            margin: 0 !important;
                            display: flex !important;
                            align-items: center !important;
                            gap: 0.5rem !important;
                        }
                        /* Search field & Button perfect height & vertical centering */
                        .fi-ta-search-field {
                            margin: 0 !important;
                            align-self: center !important;
                            min-width: 220px !important;
                        }
                        .fi-ta-search-field input {
                            border-radius: 0.75rem !important;
                            font-size: 0.825rem !important;
                            height: 2.35rem !important;
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

                        /* ===== ACTIVE TABLE FILTER INDICATORS (Filter Aktif) ===== */
                        .fi-ta-filter-indicators .fi-badge {
                            background-color: #0f766e !important;
                            border: 1px solid #0f766e !important;
                            border-radius: 0.375rem !important;
                            box-shadow: 0 1px 2px rgba(15, 118, 110, 0.2) !important;
                        }
                        .fi-ta-filter-indicators .fi-badge span,
                        .fi-ta-filter-indicators .fi-badge div {
                            color: #ffffff !important;
                            font-weight: 700 !important;
                        }
                        .fi-ta-filter-indicators .fi-badge button,
                        .fi-ta-filter-indicators .fi-badge svg {
                            color: #ffffff !important;
                            stroke: currentColor !important;
                        }
                        .fi-ta-filter-indicators .fi-badge button:hover svg {
                            color: #fca5a5 !important;
                        }

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

                        /* ===== MOBILE ACCORDION FAQ CARDS FOR TABLES ===== */
                        @media (max-width: 768px) {
                            .fi-ta-header-ctn {
                                padding: 0.75rem !important;
                                display: flex !important;
                                flex-direction: column !important;
                                align-items: stretch !important;
                                gap: 0.65rem !important;
                            }
                            .fi-ta-search-field {
                                width: 100% !important;
                                min-width: 100% !important;
                                margin: 0 !important;
                            }
                            .fi-ta-search-field input {
                                width: 100% !important;
                                text-align: left !important;
                                padding-left: 2.25rem !important;
                            }
                            .fi-ta-header { flex-direction: column !important; align-items: stretch !important; }
                            .fi-ta-header-toolbar { margin-left: 0 !important; width: 100% !important; justify-content: space-between !important; }
                            
                            /* Khusus tabel siswa yang dijadikan accordion */
                            .page-siswa .fi-ta-table { display: block !important; width: 100% !important; }
                            .page-siswa .fi-ta-table > thead { display: none !important; }
                            .page-siswa .fi-ta-table > tbody { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; padding: 0.4rem 0.2rem !important; }
                            
                            .page-siswa .fi-ta-table > tbody > tr {
                                position: relative !important;
                                cursor: pointer !important;
                                display: flex !important;
                                flex-direction: column !important;
                                background: #ffffff !important;
                                border: 1.5px solid #cbd5e1 !important;
                                border-radius: 0.65rem !important;
                                padding: 0.55rem 0.85rem !important;
                                box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.05) !important;
                                transition: all 0.2s ease !important;
                            }
                            
                            /* Chevron Indicator */
                            .page-siswa .fi-ta-table > tbody > tr::after {
                                content: "\\25BC";
                                position: absolute;
                                right: 0.85rem;
                                top: 0.65rem;
                                font-size: 0.7rem;
                                font-weight: 800;
                                color: #0f766e;
                                transition: transform 0.2s ease;
                            }
                            .page-siswa .fi-ta-table > tbody > tr.is-expanded::after {
                                transform: rotate(180deg);
                            }

                            /* Baris awal: Hanya Nama Lengkap siswa yang muncul */
                            .page-siswa .fi-ta-table > tbody > tr > td:first-child {
                                display: block !important;
                                padding: 0.1rem 1.5rem 0.1rem 0 !important;
                                border-bottom: none !important;
                                font-size: 0.875rem !important;
                                font-weight: 800 !important;
                                color: #193836 !important;
                                width: 100% !important;
                            }

                            /* Detail lain sembunyi sampai di-klik */
                            .page-siswa .fi-ta-table > tbody > tr:not(.is-expanded) > td:not(:first-child) {
                                display: none !important;
                            }

                            /* Ketika di-klik / expanded: Buka detail ke bawah */
                            .page-siswa .fi-ta-table > tbody > tr.is-expanded > td:first-child {
                                border-bottom: 1.5px solid #e2e8f0 !important;
                                padding-bottom: 0.45rem !important;
                                margin-bottom: 0.4rem !important;
                            }
                            .page-siswa .fi-ta-table > tbody > tr.is-expanded > td:not(:first-child) {
                                display: block !important;
                                padding: 0.35rem 0 !important;
                                border-bottom: 1px dashed #e2e8f0 !important;
                                font-size: 0.8rem !important;
                                width: 100% !important;
                            }
                            .page-siswa .fi-ta-table > tbody > tr.is-expanded > td:last-child {
                                border-bottom: none !important;
                                padding-top: 0.55rem !important;
                                display: flex !important;
                                align-items: center !important;
                                justify-content: flex-end !important;
                                gap: 0.5rem !important;
                            }
                        }
                    </style>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            if (window.location.pathname.includes("/siswas")) {
                                document.body.classList.add("page-siswa");
                            }
                        });
                        document.addEventListener("click", function(e) {
                            if (window.innerWidth > 768) return;
                            const row = e.target.closest(".page-siswa .fi-ta-table > tbody > tr");
                            if (!row) return;
                            if (e.target.closest("button, a, input, select, textarea, .fi-icon-btn, .fi-btn, .choices")) {
                                return;
                            }
                            row.classList.toggle("is-expanded");
                        });
                    </script>
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
