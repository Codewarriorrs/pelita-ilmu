<!-- Global Loading Transition Overlay with Pelita Ilmu Logo & Animated Rocket -->
<div id="pelita-global-loader" style="
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(255, 255, 255, 0.94);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s ease;
">
    <!-- Star Particles / Rocket Launch Trail Area -->
    <div style="position: relative; width: 140px; height: 140px; display: flex; align-items: center; justify-content: center;">
        
        <!-- Glowing Ambient Circle -->
        <div style="
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(15, 118, 110, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
            animation: pelitaPulse 2s infinite ease-in-out;
        "></div>

        <!-- Orbiting / Rising SVG Rocket -->
        <div style="
            position: absolute;
            animation: pelitaRocketLaunch 1.8s infinite ease-in-out;
            z-index: 2;
        ">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 4px 6px rgba(15, 118, 110, 0.3));">
                <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
                <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
                <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
                <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
            </svg>
        </div>

        <!-- Official Bimbel Pelita Ilmu Logo in Center -->
        <div style="
            position: relative;
            z-index: 1;
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            border: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        ">
            <img src="{{ asset('images/logo-bimbel.png') }}" alt="Pelita Ilmu" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
    </div>

    <!-- Status Subtitle -->
    <div style="margin-top: 14px; text-align: center;">
        <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; font-weight: 700; color: #0f766e; letter-spacing: -0.01em;">
            Bimbel Pelita Ilmu
        </div>
        <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.75rem; font-weight: 500; color: #64748b; margin-top: 2px;">
            Memuat data...
        </div>
    </div>
</div>

<style>
    @keyframes pelitaRocketLaunch {
        0% {
            transform: translateY(18px) scale(0.92);
            opacity: 0.7;
        }
        50% {
            transform: translateY(-16px) scale(1.08);
            opacity: 1;
        }
        100% {
            transform: translateY(18px) scale(0.92);
            opacity: 0.7;
        }
    }

    @keyframes pelitaPulse {
        0%, 100% {
            transform: scale(0.9);
            opacity: 0.5;
        }
        50% {
            transform: scale(1.15);
            opacity: 0.9;
        }
    }

    #pelita-global-loader.is-active {
        opacity: 1 !important;
        pointer-events: auto !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('pelita-global-loader');
        if (!loader) return;

        // Hook Livewire request cycle if available
        if (window.Livewire) {
            let timer = null;
            Livewire.hook('commit', ({ succeed, fail }) => {
                timer = setTimeout(() => {
                    loader.classList.add('is-active');
                }, 250);

                succeed(() => {
                    clearTimeout(timer);
                    loader.classList.remove('is-active');
                });

                fail(() => {
                    clearTimeout(timer);
                    loader.classList.remove('is-active');
                });
            });
        }

        // Show when navigating away via clicks
        window.addEventListener('beforeunload', function () {
            loader.classList.add('is-active');
        });
    });
</script>
