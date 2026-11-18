import { driver } from "driver.js";
import "driver.js/dist/driver.css";
import "../css/onboarding.css";

window.initPelitaOnboarding = function (steps, force = false) {
    if (!steps || !steps.length) return;

    // Filter steps whose elements exist in DOM or are fallback welcome
    const validSteps = steps.filter((s) => {
        if (!s.element || s.element === '#onboarding-welcome') return true;
        return document.querySelector(s.element) !== null;
    });

    if (!validSteps.length) return;

    const totalSteps = validSteps.length;

    const driverObj = driver({
        animate: true,
        allowClose: true,
        overlayOpacity: 0.55,
        stagePadding: 6,
        nextBtnText: 'Lanjut',
        prevBtnText: 'Kembali',
        doneBtnText: 'Selesai',
        onHighlightStarted: (element, step, options) => {
            // Auto open mobile sidebar if target is inside sidebar and mobile viewport
            if (window.innerWidth < 1024) {
                const isSidebarTarget = step.element && (
                    step.element.includes('a[href*=') ||
                    step.element.includes('.fi-sidebar') ||
                    step.element.includes('#pelita-tour-btn')
                );

                if (isSidebarTarget) {
                    // Cek apakah Alpine store sidebar sudah terbuka
                    if (window.Alpine && window.Alpine.store('sidebar') && !window.Alpine.store('sidebar').isOpen) {
                        window.Alpine.store('sidebar').open();
                    } else {
                        const openBtn = document.querySelector('.fi-topbar-open-sidebar-btn, button[x-on\\:click*="sidebar.open"]');
                        if (openBtn && openBtn.offsetParent !== null) {
                            openBtn.click();
                        }
                    }
                } else {
                    // Jika target di luar sidebar (topbar/konten), tutup sidebar jika sedang terbuka
                    if (window.Alpine && window.Alpine.store('sidebar') && window.Alpine.store('sidebar').isOpen) {
                        window.Alpine.store('sidebar').close();
                    }
                }
            }
        },
        steps: validSteps.map((step, idx) => {
            const isWelcome = !step.element || step.element === '#onboarding-welcome' || !document.querySelector(step.element);

            const popoverContent = `
                <div class="pelita-tour-body">
                    <p class="pelita-tour-text">${step.description}</p>
                    <div class="pelita-tour-meta">
                        <span class="pelita-tour-badge">
                            ${idx + 1} dari ${totalSteps}
                        </span>
                        <label class="pelita-tour-checkbox-label">
                            <input type="checkbox" id="pelita-tour-never-show" class="pelita-tour-checkbox">
                            <span>Jangan tampilkan lagi</span>
                        </label>
                    </div>
                </div>
            `;

            return {
                element: isWelcome ? undefined : step.element,
                popover: {
                    title: step.title,
                    description: popoverContent,
                    side: step.side || 'bottom',
                    align: step.align || 'start',
                }
            };
        }),
        onDestroyStarted: () => {
            const checkbox = document.getElementById('pelita-tour-never-show');
            if (checkbox && checkbox.checked) {
                // Send dismiss request
                fetch('/behindpelita/onboarding/dismiss', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                }).catch(err => console.error('Failed to dismiss tour:', err));
            }
            driverObj.destroy();
        }
    });

    driverObj.drive();
};
