<x-filament-widgets::widget class="fi-wi-stats-overview">
    <style>
        .po-overview-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .po-toggle-bar {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .po-bar-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            width: 100%;
        }

        .po-bar-row:not(:last-child) {
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .po-toggle-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
        }

        .po-toggle-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .po-period-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.5rem;
            background: #0f766e;
            border: 1px solid #0f766e;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .po-pill-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
        }

        .po-pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.85rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.25;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
            user-select: none;
        }

        .po-pill-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        .po-pill-btn:focus-visible {
            outline: 2px solid #0f766e;
            outline-offset: 2px;
        }

        .po-pill-btn--active {
            background: #0f766e !important;
            border-color: #0f766e !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 1px 2px rgba(15, 118, 110, 0.2);
        }

        .po-pill-btn--active:hover {
            background: #115e59 !important;
            border-color: #115e59 !important;
            color: #ffffff !important;
        }

        .po-pill-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 0.125rem;
            background: #94a3b8;
            flex-shrink: 0;
        }

        .po-pill-btn--active .po-pill-dot {
            background: #ffffff;
        }

        .po-reset-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.4rem 0.85rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #0f766e;
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .po-reset-btn:hover {
            background: #ccfbf1;
            color: #115e59;
        }

        .po-quick-filter-group {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
        }

        .po-qf-btn {
            padding: 0.3rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .po-qf-btn:hover {
            color: #0f172a;
            background: #f1f5f9;
        }

        .po-qf-btn--active {
            background: #0f766e !important;
            color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(15, 118, 110, 0.2);
        }
            box-shadow: 0 1px 2px rgba(15, 118, 110, 0.2);
        }
            box-shadow: 0 1px 2px rgba(15, 118, 110, 0.25);
        }

        .po-qf-btn--active:hover {
            background: #0d655e !important;
            color: #ffffff !important;
        }

        .po-stats-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        @media (min-width: 640px) {
            .po-stats-grid--cols-2,
            .po-stats-grid--cols-3,
            .po-stats-grid--cols-4,
            .po-stats-grid--cols-5 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .po-stats-grid--cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .po-stats-grid--cols-4,
            .po-stats-grid--cols-5 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1280px) {
            .po-stats-grid--cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
            .po-stats-grid--cols-5 {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        .po-empty-cards {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border-radius: 0.875rem;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #475569;
            font-size: 0.875rem;
        }
    </style>

    <div class="po-overview-wrapper">
        <div class="po-toggle-bar">
            <!-- Baris 1: Judul, Pemilih Bulan & Quick Filter Hari Ini / Bulan Ini / Semua -->
            <div class="po-bar-row">
                <div class="po-toggle-meta">
                    <span class="po-toggle-title">Kartu Ringkasan</span>
                    <div class="po-period-chip">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="margin-right: 0.25rem; flex-shrink: 0;">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <select 
                            wire:change="setSpecificMonth($event.target.value)" 
                            title="Pilih Bulan untuk Melihat Rekap Pendapatan Bulan Lampau"
                            style="background: transparent; color: #ffffff; font-size: 0.75rem; font-weight: 800; border: none; outline: none; cursor: pointer; padding: 0.15rem 0.25rem; border-radius: 0.25rem;">
                            @php
                                $namaBulan = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                            @endphp
                            @foreach ($namaBulan as $num => $nama)
                                <option value="{{ $num }}" {{ (int) ($currentMonth ?? now()->month) === $num ? 'selected' : '' }} style="color: #193836; background: #ffffff;">
                                    {{ $nama }} {{ $currentYear ?? now()->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Quick Filter Switcher: Hari Ini, Bulan Ini, Semua Periode -->
                <div class="po-quick-filter-group" title="Ubah Periode Pemasukan">
                    <button 
                        type="button" 
                        wire:click="setPeriodeFilter('HARI_INI')" 
                        wire:loading.attr="disabled"
                        class="po-qf-btn {{ str_contains($labelPeriode, 'Hari Ini') ? 'po-qf-btn--active' : '' }}">
                        Hari Ini
                    </button>
                    <button 
                        type="button" 
                        wire:click="setPeriodeFilter('BULAN')" 
                        wire:loading.attr="disabled"
                        class="po-qf-btn {{ (!str_contains($labelPeriode, 'Hari Ini') && !str_contains($labelPeriode, 'Semua Periode')) ? 'po-qf-btn--active' : '' }}">
                        Bulan Ini
                    </button>
                    <button 
                        type="button" 
                        wire:click="setPeriodeFilter('SEMUA')" 
                        wire:loading.attr="disabled"
                        class="po-qf-btn {{ str_contains($labelPeriode, 'Semua Periode') ? 'po-qf-btn--active' : '' }}">
                        Semua
                    </button>
                </div>
            </div>

            <!-- Baris 2: Filter Toggle Card Visibility (Simetris Sejajar) -->
            <div class="po-bar-row">
                <div class="po-pill-group" role="group" aria-label="Pilih kartu statistik pembayaran">
                    @foreach ($cardOptions as $key => $label)
                        @php
                            $isActive = in_array($key, $visibleCards, true);
                        @endphp
                        <button
                            type="button"
                            wire:click="toggleCard('{{ $key }}')"
                            wire:loading.attr="disabled"
                            aria-pressed="{{ $isActive ? 'true' : 'false' }}"
                            class="po-pill-btn {{ $isActive ? 'po-pill-btn--active' : '' }}"
                        >
                            <span class="po-pill-dot" aria-hidden="true"></span>
                            <span>{{ $label }}</span>
                        </button>
                    @endforeach

                    @if (count($visibleCards) < count($cardOptions))
                        <button
                            type="button"
                            wire:click="showAllCards"
                            class="po-reset-btn"
                        >
                            Tampilkan Semua
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if (count($visibleCards) > 0)
            {{ $this->content }}
        @else
            <div class="po-empty-cards">
                <span>Seluruh kartu ringkasan sedang disembunyikan. Klik salah satu pill di atas untuk menampilkan kartu.</span>
                <button type="button" wire:click="showAllCards" class="po-pill-btn po-pill-btn--active">
                    Tampilkan Semua Kartu
                </button>
            </div>
        @endif
    </div>
</x-filament-widgets::widget>

