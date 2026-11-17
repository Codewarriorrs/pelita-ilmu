<style>
    .pelita-bell-wrapper {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        align-self: center !important;
        margin-right: 0.5rem !important;
        z-index: 50 !important;
    }
    .pelita-bell-btn {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 2.25rem !important;
        height: 2.25rem !important;
        min-width: 2.25rem !important;
        min-height: 2.25rem !important;
        border-radius: 9999px !important;
        background: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
        padding: 0 !important;
    }
    .pelita-bell-btn:hover {
        background: #0f766e !important;
        color: #ffffff !important;
        border-color: #0f766e !important;
        transform: scale(1.05) !important;
    }
    .pelita-bell-btn svg {
        width: 1.25rem !important;
        height: 1.25rem !important;
        stroke-width: 2.2 !important;
    }
    .pelita-bell-badge {
        position: absolute !important;
        top: -0.2rem !important;
        right: -0.2rem !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 1.15rem !important;
        height: 1.15rem !important;
        padding: 0 0.25rem !important;
        font-size: 0.65rem !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        background-color: #dc2626 !important;
        border-radius: 9999px !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
    }
</style>

<div x-data="pelitaNotificationCenter()" x-init="init()" class="pelita-bell-wrapper">
    <!-- Bell Trigger Button -->
    <button 
        type="button" 
        @click="toggleDropdown()"
        class="pelita-bell-btn"
        title="Pusat Notifikasi">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <template x-if="unreadCount > 0">
            <span 
                x-text="unreadCount" 
                class="pelita-bell-badge animate-pulse">
            </span>
        </template>
    </button>

    <!-- Dropdown Panel (Pop-out dari lonceng) -->
    <div 
        x-show="isOpen" 
        @click.away="isOpen = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        x-cloak
        style="display: none; z-index: 9999;"
        class="absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden text-slate-800">
        
        <div class="px-4 py-3 bg-slate-50/90 border-b border-slate-200/80 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-extrabold text-xs uppercase tracking-wider text-slate-900">Aktivitas & Notifikasi</span>
                <span x-show="items.length > 0" x-text="items.length" class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full"></span>
            </div>
            <button 
                type="button" 
                @click="markAllRead()"
                x-show="unreadCount > 0"
                class="text-[11px] text-emerald-700 hover:text-emerald-900 font-bold focus:outline-none">
                Tandai sudah dibaca
            </button>
        </div>

        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
            <template x-if="items.length === 0">
                <div class="p-8 text-center text-xs text-slate-500">
                    <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Semua aktivitas sudah up to date.
                </div>
            </template>

            <template x-for="item in items" :key="item.id">
                <a 
                    :href="item.url" 
                    @click="markAsRead(item.id)"
                    class="block p-3.5 hover:bg-slate-50 transition-colors group">
                    <div class="flex items-start gap-3">
                        <span 
                            class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0"
                            :style="'background-color: ' + item.color">
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-900 group-hover:text-emerald-800 leading-snug" x-text="item.title"></p>
                            <p class="text-[11px] text-slate-600 mt-0.5 line-clamp-2" x-text="item.message"></p>
                            <span class="text-[10px] text-slate-400 mt-1 block" x-text="item.time"></span>
                        </div>
                    </div>
                </a>
            </template>
        </div>
    </div>

    <!-- Toast Container Kiri Bawah (5 Detik Animasi) -->
    <div class="fixed bottom-5 left-5 z-[9999] flex flex-col gap-2 pointer-events-none" style="max-width: 360px;">
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-show="toast.visible"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-x-8 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-95"
                class="pointer-events-auto flex items-start gap-3 bg-slate-900/95 backdrop-blur-md text-white p-3.5 rounded-2xl shadow-2xl border-l-4 border-emerald-500 text-xs w-full">
                <span 
                    class="w-2.5 h-2.5 rounded-full mt-1 flex-shrink-0"
                    :style="'background-color: ' + toast.color">
                </span>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-white text-xs" x-text="toast.title"></div>
                    <div class="text-slate-300 text-[11px] mt-0.5 leading-tight" x-text="toast.message"></div>
                </div>
                <button 
                    type="button" 
                    @click="removeToast(toast.id)"
                    class="text-slate-400 hover:text-white ml-2 flex-shrink-0 focus:outline-none text-base">
                    &times;
                </button>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pelitaNotificationCenter', () => ({
        isOpen: false,
        items: [],
        unreadCount: 0,
        toasts: [],
        seenIds: new Set(),
        pollTimer: null,

        init() {
            try {
                const storedSeen = JSON.parse(sessionStorage.getItem('pelita_seen_notif_ids') || '[]');
                this.seenIds = new Set(storedSeen);
            } catch (e) {
                this.seenIds = new Set();
            }

            this.fetchFeed(true);
            this.pollTimer = setInterval(() => {
                this.fetchFeed(false);
            }, 8000);
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },

        async fetchFeed(isFirstLoad = false) {
            try {
                const res = await fetch('{{ route("notifications.feed") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();
                const newItems = data.items || [];

                this.items = newItems;
                this.unreadCount = newItems.filter(i => !this.seenIds.has(i.id)).length;

                // Tampilkan toast untuk notif yang baru muncul
                newItems.forEach(item => {
                    if (!this.seenIds.has(item.id)) {
                        this.showToast(item);
                        this.seenIds.add(item.id);
                    }
                });

                sessionStorage.setItem('pelita_seen_notif_ids', JSON.stringify(Array.from(this.seenIds)));
            } catch (e) {
                // Ignore silent network issues
            }
        },

        showToast(item) {
            const toast = {
                id: item.id + '_' + Date.now(),
                title: item.title,
                message: item.message,
                color: item.color || '#10b981',
                visible: true,
            };

            this.toasts.push(toast);

            setTimeout(() => {
                this.removeToast(toast.id);
            }, 5000);
        },

        removeToast(id) {
            const idx = this.toasts.findIndex(t => t.id === id);
            if (idx !== -1) {
                this.toasts[idx].visible = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300);
            }
        },

        markAsRead(id) {
            this.seenIds.add(id);
            this.unreadCount = this.items.filter(i => !this.seenIds.has(i.id)).length;
            sessionStorage.setItem('pelita_seen_notif_ids', JSON.stringify(Array.from(this.seenIds)));
        },

        markAllRead() {
            this.items.forEach(i => this.seenIds.add(i.id));
            this.unreadCount = 0;
            sessionStorage.setItem('pelita_seen_notif_ids', JSON.stringify(Array.from(this.seenIds)));
        }
    }));
});
</script>
