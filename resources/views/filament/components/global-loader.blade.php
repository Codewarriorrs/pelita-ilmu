<!-- Global Loading Transition Overlay with Pelita Ilmu Logo -->
<div id="pelita-global-loader" style="
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
">
    <div style="position: relative; width: 88px; height: 88px; display: flex; align-items: center; justify-content: center;">
        <!-- Clean Elegant Glowing Pulse -->
        <div style="
            position: absolute;
            width: 84px;
            height: 84px;
            border-radius: 50%;
            border: 2.5px solid #0f766e;
            border-top-color: #FFE500;
            animation: pelitaSpinRing 0.9s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
        "></div>

        <!-- Official Bimbel Pelita Ilmu Logo in Center -->
        <div style="
            position: relative;
            z-index: 1;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
        ">
            <img src="{{ asset('images/logo-bimbel.png') }}" alt="Pelita Ilmu" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
    </div>
</div>

<style>
    @keyframes pelitaSpinRing {
        to { transform: rotate(360deg); }
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

        if (window.Livewire) {
            let timer = null;
            Livewire.hook('commit', ({ succeed, fail }) => {
                timer = setTimeout(() => {
                    loader.classList.add('is-active');
                }, 300);

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

        window.addEventListener('beforeunload', function () {
            loader.classList.add('is-active');
        });
    });
</script>
