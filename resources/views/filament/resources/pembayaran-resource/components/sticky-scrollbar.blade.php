<div
    x-data="{
        tableEl: null,
        scrollWidth: 0,
        clientWidth: 0,
        needsScroll: false,
        syncingFromBar: false,
        syncingFromTable: false,
        resizeObserver: null,
        mutationObserver: null,

        init() {
            this.$nextTick(() => this.attach());

            document.addEventListener('livewire:navigated', () => {
                this.$nextTick(() => this.attach());
            });

            if (window.Livewire) {
                Livewire.hook('morph.updated', () => {
                    this.$nextTick(() => this.attach());
                });
                Livewire.hook('commit', ({ succeed }) => {
                    succeed(() => {
                        this.$nextTick(() => this.attach());
                    });
                });
            }
        },

        findTableScroller() {
            const candidates = Array.from(document.querySelectorAll('.fi-ta-content-ctn, .fi-ta-content'));
            return candidates.find((el) => el.scrollWidth > el.clientWidth + 1)
                || candidates[0]
                || null;
        },

        attach() {
            const candidate = this.findTableScroller();
            if (!candidate) {
                this.needsScroll = false;
                return;
            }

            if (this.tableEl !== candidate) {
                if (this.tableEl && this._onTableScroll) {
                    this.tableEl.removeEventListener('scroll', this._onTableScroll);
                }

                this.tableEl = candidate;
                this._onTableScroll = () => {
                    if (this.syncingFromBar) {
                        this.syncingFromBar = false;
                        return;
                    }
                    if (!this.$refs.bar) return;
                    this.syncingFromTable = true;
                    this.$refs.bar.scrollLeft = this.tableEl.scrollLeft;
                };
                this.tableEl.addEventListener('scroll', this._onTableScroll, { passive: true });

                if (this.resizeObserver) this.resizeObserver.disconnect();
                this.resizeObserver = new ResizeObserver(() => this.recalculate());
                this.resizeObserver.observe(this.tableEl);

                const innerTable = this.tableEl.querySelector('.fi-ta-table');
                if (innerTable) {
                    this.resizeObserver.observe(innerTable);
                }

                if (this.mutationObserver) this.mutationObserver.disconnect();
                this.mutationObserver = new MutationObserver(() => this.recalculate());
                this.mutationObserver.observe(this.tableEl, {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    attributeFilter: ['class', 'style']
                });
            }

            this.recalculate();
        },

        recalculate() {
            if (!this.tableEl) {
                this.needsScroll = false;
                return;
            }

            const sw = this.tableEl.scrollWidth;
            const cw = this.tableEl.clientWidth;

            this.scrollWidth = sw;
            this.clientWidth = cw;
            this.needsScroll = sw > cw + 2;

            if (this.needsScroll && this.$refs.bar) {
                this.$nextTick(() => {
                    if (this.$refs.bar) {
                        this.$refs.bar.scrollLeft = this.tableEl.scrollLeft;
                    }
                });
            }
        },

        onBarScroll() {
            if (this.syncingFromTable) {
                this.syncingFromTable = false;
                return;
            }
            if (!this.tableEl || !this.$refs.bar) return;
            this.syncingFromBar = true;
            this.tableEl.scrollLeft = this.$refs.bar.scrollLeft;
        },

        destroy() {
            if (this.tableEl && this._onTableScroll) {
                this.tableEl.removeEventListener('scroll', this._onTableScroll);
            }
            if (this.resizeObserver) this.resizeObserver.disconnect();
            if (this.mutationObserver) this.mutationObserver.disconnect();
        }
    }"
    x-show="needsScroll"
    x-cloak
    class="pembayaran-sticky-scroll-shell"
>
    <style>
        .fi-ta-content-ctn,
        .fi-ta-content {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        .fi-ta-content-ctn::-webkit-scrollbar,
        .fi-ta-content::-webkit-scrollbar {
            display: none !important;
            height: 0 !important;
        }

        .pembayaran-sticky-scroll-shell {
            position: sticky;
            bottom: 0;
            z-index: 30;
            margin-top: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            box-shadow: 0 -4px 16px -4px rgba(15, 23, 42, 0.12);
        }

        .pembayaran-sticky-scroll-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.35rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: #065f46;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .pembayaran-sticky-scroll-track {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: thin;
            scrollbar-color: #10b981 #e2e8f0;
        }

        .pembayaran-sticky-scroll-track::-webkit-scrollbar {
            height: 10px;
        }

        .pembayaran-sticky-scroll-track::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 9999px;
        }

        .pembayaran-sticky-scroll-track::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 9999px;
            border: 2px solid #e2e8f0;
        }

        .pembayaran-sticky-scroll-track::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }

        .pembayaran-sticky-scroll-spacer {
            height: 1px;
        }
    </style>

    <div class="pembayaran-sticky-scroll-header">
        <span>Geser Horizontal Tabel</span>
        <span>← →</span>
    </div>

    <div
        x-ref="bar"
        x-on:scroll="onBarScroll()"
        class="pembayaran-sticky-scroll-track"
        :style="`max-width: ${clientWidth}px`"
    >
        <div
            class="pembayaran-sticky-scroll-spacer"
            :style="`width: ${scrollWidth}px`"
        ></div>
    </div>
</div>

