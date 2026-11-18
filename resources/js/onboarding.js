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
        overlayOpacity: 0.6,
        stagePadding: 6,
        nextBtnText: 'Lanjut &rarr;',
        prevBtnText: '&larr; Kembali',
        doneBtnText: 'Selesai ✨',
        onHighlightStarted: (element, step, options) => {
            // Auto open mobile sidebar if target is inside sidebar and mobile viewport
            if (window.innerWidth < 1024 && step.element && step.element.includes('a[href*=')) {
                const sidebarToggle = document.querySelector('button[x-on\\:click*="sidebar"], button[aria-label*="sidebar"], .fi-topbar button');
                const sidebar = document.querySelector('.fi-sidebar');
                if (sidebar && sidebar.classList.contains('-translate-x-full') && sidebarToggle) {
                    sidebarToggle.click();
                }
            }
        },
        steps: validSteps.map((step, idx) => {
            const isWelcome = !step.element || step.element === '#onboarding-welcome' || !document.querySelector(step.element);
            const isLast = idx === totalSteps - 1;

            const popoverContent = `
                <div class="pelita-tour-body">
                    <p class="text-sm text-slate-600 leading-relaxed">${step.description}</p>
                    <div class="pelita-tour-footer mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                            ${idx + 1} dari ${totalSteps}
                        </span>
                        <label class="flex items-center gap-1.5 text-xs text-slate-500 cursor-pointer hover:text-slate-800 select-none">
                            <input type="checkbox" id="pelita-tour-never-show" class="w-3.5 h-3.5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
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
