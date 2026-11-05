@if (filament()->auth()->check())
<div class="fi-sidebar-logout-container" style="padding: 0.65rem 1rem; border-top: 1px solid rgba(0, 0, 0, 0.08); margin-top: auto; background: transparent;">
    <form action="{{ filament()->getLogoutUrl() }}" method="post" style="margin: 0; width: 100%;">
        @csrf
        <button type="submit" 
                class="fi-sidebar-logout-btn"
                style="display: flex; align-items: center; gap: 0.75rem; width: 100%; padding: 0.5rem 0.5rem; font-size: 0.875rem; font-weight: 700; color: #dc2626; background: transparent; border: none; cursor: pointer; transition: opacity 0.15s ease, transform 0.15s ease; text-align: left;"
                onmouseover="this.style.opacity='0.8'; this.style.transform='translateX(2px)';"
                onmouseout="this.style.opacity='1'; this.style.transform='none';">
            <svg style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; color: #dc2626; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span style="letter-spacing: 0.02em;">Keluar</span>
        </button>
    </form>
</div>
@endif
