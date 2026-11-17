<style>
    .pelita-bell-wrapper {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        align-self: center !important;
        margin-right: 0.75rem !important;
        z-index: 50 !important;
    }
    .pelita-bell-btn {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        cursor: pointer !important;
        padding: 0.25rem !important;
        color: #475569 !important;
        transition: transform 0.15s ease, color 0.15s ease !important;
    }
    .pelita-bell-btn:hover {
        color: #0f766e !important;
        transform: scale(1.1) !important;
    }
    .pelita-bell-btn svg {
        width: 1.5rem !important;
        height: 1.5rem !important;
        stroke-width: 2 !important;
    }
    .pelita-bell-badge {
        position: absolute !important;
        top: -0.15rem !important;
        right: -0.15rem !important;
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
    .pelita-notif-dropdown {
        position: absolute !important;
        top: calc(100% + 0.5rem) !important;
        right: 0 !important;
        width: 22rem !important;
        max-width: 90vw !important;
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        z-index: 99999 !important;
        font-family: inherit !important;
        color: #1e293b !important;
    }
    .pelita-notif-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0.75rem 1rem !important;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .pelita-notif-header-title {
        font-size: 0.75rem !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #0f172a !important;
    }
    .pelita-notif-count {
        background-color: #ccfbf1 !important;
        color: #0f766e !important;
        font-size: 0.7rem !important;
        font-weight: 800 !important;
        padding: 0.1rem 0.45rem !important;
        border-radius: 9999px !important;
        margin-left: 0.35rem !important;
    }
    .pelita-notif-mark-btn {
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        color: #0f766e !important;
        background: transparent !important;
        border: none !important;
        cursor: pointer !important;
    }
    .pelita-notif-mark-btn:hover {
        color: #115e59 !important;
        text-decoration: underline !important;
    }
    .pelita-notif-body {
        max-height: 20rem !important;
        overflow-y: auto !important;
    }
    .pelita-notif-item {
        display: flex !important;
        align-items: flex-start !important;
        gap: 0.75rem !important;
        padding: 0.75rem 1rem !important;
        border-bottom: 1px solid #f1f5f9 !important;
        text-decoration: none !important;
        transition: background-color 0.15s ease !important;
    }
    .pelita-notif-item:hover {
        background-color: #f8fafc !important;
    }
    .pelita-notif-dot {
        width: 0.5rem !important;
        height: 0.5rem !important;
        border-radius: 9999px !important;
        margin-top: 0.35rem !important;
        flex-shrink: 0 !important;
    }
    .pelita-notif-title {
        font-size: 0.75rem !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        line-height: 1.25 !important;
        margin-bottom: 0.2rem !important;
    }
    .pelita-notif-msg {
        font-size: 0.7rem !important;
        color: #475569 !important;
        line-height: 1.3 !important;
        margin-bottom: 0.2rem !important;
    }
    .pelita-notif-time {
        font-size: 0.65rem !important;
        color: #94a3b8 !important;
    }
    .pelita-toast-wrapper {
        position: fixed !important;
        bottom: 1.25rem !important;
        left: 1.25rem !important;
        z-index: 99999 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0.5rem !important;
        pointer-events: none !important;
        max-width: 22rem !important;
    }
    .pelita-toast-item {
        pointer-events: auto !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: 0.75rem !important;
        background-color: #0f172a !important;
        color: #ffffff !important;
        padding: 0.75rem 1rem !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
        border-left: 4px solid #0f766e !important;
        font-size: 0.75rem !important;
    }
</style>

<div x-data="pelitaNotificationCenter()" x-init="init()" class="pelita-bell-wrapper">
    <!-- Bell Trigger Button: Polos tanpa background dan tanpa border circle -->
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
                class="pelita-bell-badge">
            </span>
        </template>
    </button>

    <!-- Dropdown Panel (Pop-out dari lonceng di kanan atas) -->
    <div 
        x-show="isOpen" 
        @click.away="isOpen = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        style="display: none;"
        class="pelita-notif-dropdown">
        
        <div class="pelita-notif-header">
            <div style="display: flex; align-items: center;">
                <span class="pelita-notif-header-title">Aktivitas & Notifikasi</span>
                <span x-show="items.length > 0" x-text="items.length" class="pelita-notif-count"></span>
            </div>
            <button 
                type="button" 
                @click="markAllRead()"
                x-show="unreadCount > 0"
                class="pelita-notif-mark-btn">
                Tandai dibaca
            </button>
        </div>

        <div class="pelita-notif-body">
            <template x-if="items.length === 0">
                <div style="padding: 2rem 1rem; text-align: center; color: #64748b; font-size: 0.75rem;">
                    Semua aktivitas sudah up to date.
                </div>
            </template>

            <template x-for="item in items" :key="item.id">
                <a 
                    :href="item.url" 
                    @click="markAsRead(item.id)"
                    class="pelita-notif-item">
                    <span 
                        class="pelita-notif-dot"
                        :style="'background-color: ' + item.color">
                    </span>
                    <div style="flex: 1; min-width: 0;">
                        <div class="pelita-notif-title" x-text="item.title"></div>
                        <div class="pelita-notif-msg" x-text="item.message"></div>
                        <span class="pelita-notif-time" x-text="item.time"></span>
                    </div>
                </a>
            </template>
        </div>
    </div>

    <!-- Toast Container Kiri Bawah (5 Detik Animasi) -->
    <div class="pelita-toast-wrapper">
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-show="toast.visible"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="pelita-toast-item">
                <span 
                    class="pelita-notif-dot"
                    :style="'background-color: ' + toast.color">
                </span>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 800; font-size: 0.75rem;" x-text="toast.title"></div>
                    <div style="color: #cbd5e1; font-size: 0.7rem; margin-top: 0.15rem;" x-text="toast.message"></div>
                </div>
                <button 
                    type="button" 
                    @click="removeToast(toast.id)"
                    style="color: #94a3b8; background: transparent; border: none; cursor: pointer; font-size: 1rem; line-height: 1;">
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
