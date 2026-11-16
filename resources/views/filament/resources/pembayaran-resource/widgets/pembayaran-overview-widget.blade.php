<x-filament-widgets::widget class="fi-wi-stats-overview">
    <style>
        .po-overview-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .po-toggle-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem 1rem;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border: 1px solid rgba(25, 56, 54, 0.12);
            border-radius: 0.875rem;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.05);
        }

        .po-toggle-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }

        .po-toggle-title {
            font-size: 0.8125rem;
            font-weight: 700;
            color: #193836;
            letter-spacing: -0.01em;
        }

        .po-period-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
            background: #ecfdf5;
            border: 1px solid #10b981;
            color: #065f46;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .po-pill-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }

        .po-pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.375rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.25;
            cursor: pointer;
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease, transform 0.12s ease;
            border: 1.5px solid #cbd5e1;
            background: #f8fafc;
            color: #475569;
            user-select: none;
        }

        .po-pill-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #1e293b;
        }

        .po-pill-btn:focus-visible {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        .po-pill-btn--active {
            background: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
            font-weight: 700;
            box-shadow: 0 1px 2px rgba(16, 185, 129, 0.12);
        }

        .po-pill-btn--active:hover {
            background: #d1fae5;
            border-color: #059669;
            color: #064e3b;
        }

        .po-pill-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 9999px;
            background: #94a3b8;
            flex-shrink: 0;
        }

        .po-pill-btn--active .po-pill-dot {
            background: #10b981;
        }

        .po-reset-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.375rem 0.7rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #0f766e;
            background: transparent;
            border: 1px dashed #5eead4;
            cursor: pointer;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        .po-reset-btn:hover {
            background: #f0fdfa;
            color: #115e59;
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
            <div class="po-toggle-meta">
                <span class="po-toggle-title">Kartu Ringkasan</span>
                <span class="po-period-chip">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    {{ $labelPeriode }}
                </span>
            </div>

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

