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
        color: #ffffff !important;
        transition: transform 0.15s ease, color 0.15s ease !important;
    }
    .pelita-bell-btn:hover {
        color: #6ee7b7 !important;
        transform: scale(1.1) !important;
    }
    .pelita-bell-btn svg {
        width: 1.5rem !important;
        height: 1.5rem !important;
        stroke-width: 2 !important;
    }
    .pelita-bell-badge {
        position: absolute !important;
        top: -0.25rem !important;
        right: -0.35rem !important;
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
        box-shadow: 0 2px 4px rgba(0,0,0,0.25) !important;
        pointer-events: none !important;
        z-index: 10 !important;
    }
    .pelita-notif-dropdown {
        position: absolute !important;
        top: calc(100% + 0.6rem) !important;
        right: 0 !important;
        width: 23rem !important;
        max-width: 92vw !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.875rem !important;
        box-shadow: 0 12px 30px -5px rgba(0, 0, 0, 0.18), 0 8px 12px -6px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        z-index: 99999 !important;
        font-family: inherit !important;
        color: #1e293b !important;
    }
    .pelita-notif-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0.85rem 1.15rem !important;
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    .pelita-notif-header-title {
        font-size: 0.78rem !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #193836 !important;
    }
    .pelita-notif-count {
        background-color: #0f766e !important;
        color: #ffffff !important;
        font-size: 0.7rem !important;
        font-weight: 800 !important;
        padding: 0.15rem 0.5rem !important;
        border-radius: 9999px !important;
        margin-left: 0.4rem !important;
    }
    .pelita-notif-mark-btn {
        font-size: 0.72rem !important;
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
        max-height: 22rem !important;
        overflow-y: auto !important;
    }
    .pelita-notif-item {
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 0.75rem !important;
        padding: 0.85rem 1.15rem !important;
        border-bottom: 1px solid #f1f5f9 !important;
        text-decoration: none !important;
        transition: background-color 0.15s ease !important;
        cursor: pointer !important;
    }
    .pelita-notif-item:hover {
        background-color: #f8fafc !important;
    }
    .pelita-notif-item.is-unread {
        background-color: #f0fdf4 !important;
    }
    .pelita-notif-item.is-unread:hover {
        background-color: #dcfce7 !important;
    }
    .pelita-notif-content {
        flex: 1 !important;
        min-width: 0 !important;
    }
    .pelita-notif-title {
        font-size: 0.78rem !important;
        font-weight: 800 !important;
        color: #193836 !important;
        line-height: 1.25 !important;
        margin-bottom: 0.2rem !important;
    }
    .pelita-notif-msg {
        font-size: 0.72rem !important;
        color: #475569 !important;
        line-height: 1.35 !important;
        margin-bottom: 0.25rem !important;
    }
    .pelita-notif-time {
        font-size: 0.65rem !important;
        color: #94a3b8 !important;
        font-weight: 600 !important;
    }
    .pelita-notif-delete-btn {
        background: transparent !important;
        border: none !important;
        color: #94a3b8 !important;
        cursor: pointer !important;
        padding: 0.25rem !important;
        font-size: 0.9rem !important;
        line-height: 1 !important;
        border-radius: 0.25rem !important;
        transition: color 0.15s, background-color 0.15s !important;
    }
    .pelita-notif-delete-btn:hover {
        color: #dc2626 !important;
        background-color: #fee2e2 !important;
    }
    .pelita-notif-footer {
        padding: 0.65rem 1rem !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        text-align: center !important;
    }
    .pelita-notif-more-btn {
        background: transparent !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f766e !important;
        font-weight: 700 !important;
        font-size: 0.72rem !important;
        padding: 0.35rem 0.75rem !important;
        border-radius: 0.375rem !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
    }
    .pelita-notif-more-btn:hover {
        background-color: #0f766e !important;
        color: #ffffff !important;
        border-color: #0f766e !important;
    }

    /* ===== TOAST PUSH NOTIFICATION (KIRI BAWAH, TIDAK MENUTUPI BUTTON KELUAR) ===== */
    .pelita-toast-wrapper {
        position: fixed !important;
        z-index: 99999 !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0.6rem !important;
        pointer-events: none !important;
        max-width: 24rem !important;
        width: calc(100vw - 2rem) !important;
    }
    @media (min-width: 1024px) {
        .pelita-toast-wrapper {
            bottom: 1.5rem !important;
            left: 17.5rem !important; /* Aman di samping area sidebar */
        }
    }
    @media (max-width: 1023px) {
        .pelita-toast-wrapper {
            bottom: 5.5rem !important; /* Di atas bar bawah mobile / logout */
            left: 1rem !important;
        }
    }
    .pelita-toast-item {
        pointer-events: auto !important;
        display: flex !important;
        align-items: flex-start !important;
        gap: 0.75rem !important;
        background-color: #193836 !important; /* Dominan warna hijau tema Pelita */
        color: #ffffff !important;
        padding: 0.85rem 1.15rem !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.35) !important;
        border-left: 4px solid #10b981 !important;
        font-size: 0.75rem !important;
        animation: pelitaSlideSmooth 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }
    @keyframes pelitaSlideSmooth {
        from {
            opacity: 0;
            transform: translateY(16px) scale(0.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .pelita-toast-title {
        font-weight: 800 !important;
        font-size: 0.78rem !important;
        color: #ffffff !important;
    }
    .pelita-toast-message {
        color: #d1fae5 !important;
        font-size: 0.72rem !important;
        margin-top: 0.2rem !important;
        line-height: 1.3 !important;
    }
    .pelita-toast-close {
        color: #94a3b8 !important;
        background: transparent !important;
        border: none !important;
        cursor: pointer !important;
        font-size: 1.1rem !important;
        line-height: 1 !important;
        padding: 0 0.2rem !important;
    }
    .pelita-toast-close:hover {
        color: #ffffff !important;
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
                <span x-show="visibleItems.length > 0" x-text="visibleItems.length" class="pelita-notif-count"></span>
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
            <template x-if="visibleItems.length === 0">
                <div style="padding: 2.5rem 1rem; text-align: center; color: #64748b; font-size: 0.75rem;">
                    Tidak ada notifikasi baru saat ini.
                </div>
            </template>

            <template x-for="item in visibleItems.slice(0, displayLimit)" :key="item.id">
                <div 
                    @click="handleItemClick(item)"
                    :class="{'pelita-notif-item': true, 'is-unread': !readIds.has(item.id)}">
                    <div class="pelita-notif-content">
                        <div class="pelita-notif-title" x-text="item.title"></div>
                        <div class="pelita-notif-msg" x-text="item.message"></div>
                        <span class="pelita-notif-time" x-text="item.time"></span>
                    </div>
                    <button 
                        type="button" 
                        @click.stop="deleteNotification(item.id)" 
                        class="pelita-notif-delete-btn"
                        title="Hapus notifikasi ini">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <template x-if="visibleItems.length > displayLimit">
            <div class="pelita-notif-footer">
                <button 
                    type="button" 
                    @click.stop="displayLimit += 10" 
                    class="pelita-notif-more-btn">
                    +10 Notifikasi Terdahulu
                </button>
            </div>
        </template>
    </div>

    <!-- Toast Container Kiri Bawah (Smooth 5 Detik, Tema Dominan, Tanpa Dot) -->
    <div class="pelita-toast-wrapper">
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-show="toast.visible"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="pelita-toast-item">
                <div style="flex: 1; min-width: 0;">
                    <div class="pelita-toast-title" x-text="toast.title"></div>
                    <div class="pelita-toast-message" x-text="toast.message"></div>
                </div>
                <button 
                    type="button" 
                    @click="removeToast(toast.id)"
                    class="pelita-toast-close">
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
        rawItems: [],
        deletedIds: new Set(),
        readIds: new Set(),
        toasts: [],
        displayLimit: 10,
        pollTimer: null,

        get visibleItems() {
            return this.rawItems.filter(item => !this.deletedIds.has(String(item.id)));
        },

        get unreadCount() {
            return this.visibleItems.filter(item => !this.readIds.has(String(item.id))).length;
        },

        init() {
            try {
                const storedDeleted = JSON.parse(localStorage.getItem('pelita_deleted_notif_ids') || '[]');
                this.deletedIds = new Set(storedDeleted.map(String));

                const storedRead = JSON.parse(localStorage.getItem('pelita_read_notif_ids') || '[]');
                this.readIds = new Set(storedRead.map(String));
            } catch (e) {
                this.deletedIds = new Set();
                this.readIds = new Set();
            }

            this.fetchFeed(true);
            this.pollTimer = setInterval(() => {
                this.fetchFeed(false);
            }, 10000);
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

                // Cek item baru untuk dimunculkan di toast push notif
                if (!isFirstLoad) {
                    newItems.forEach(item => {
                        const idStr = String(item.id);
                        const alreadyExists = this.rawItems.some(i => String(i.id) === idStr);
                        if (!alreadyExists && !this.deletedIds.has(idStr)) {
                            this.showToast(item);
                        }
                    });
                }

                this.rawItems = newItems;
            } catch (e) {
                // Ignore silent network issues
            }
        },

        showToast(item) {
            const toast = {
                id: item.id + '_' + Date.now(),
                title: item.title,
                message: item.message,
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

        handleItemClick(item) {
            this.markAsRead(item.id);
            if (item.url && item.url !== '#') {
                window.location.href = item.url;
            }
        },

        markAsRead(id) {
            this.readIds.add(String(id));
            localStorage.setItem('pelita_read_notif_ids', JSON.stringify(Array.from(this.readIds)));
        },

        markAllRead() {
            this.visibleItems.forEach(i => this.readIds.add(String(i.id)));
            localStorage.setItem('pelita_read_notif_ids', JSON.stringify(Array.from(this.readIds)));
        },

        deleteNotification(id) {
            const idStr = String(id);
            this.deletedIds.add(idStr);
            this.readIds.add(idStr);
            localStorage.setItem('pelita_deleted_notif_ids', JSON.stringify(Array.from(this.deletedIds)));
            localStorage.setItem('pelita_read_notif_ids', JSON.stringify(Array.from(this.readIds)));
        }
    }));
});
</script>
