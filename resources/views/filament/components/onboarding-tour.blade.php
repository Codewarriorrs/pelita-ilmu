@php
    $user = filament()->auth()->user();
    $role = $user && $user->hasRole('tentor') ? 'tentor' : 'admin';
    $allTours = config('onboarding', []);
    $shouldAutoStart = session()->pull('show_onboarding_tour', false) && !($user->hide_onboarding_tour ?? false);
@endphp

@vite(['resources/js/onboarding.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allTours = @json($allTours);
        const shouldAutoStart = @json($shouldAutoStart);
        const userRole = @json($role);

        function getTourStepsForCurrentPage() {
            if (userRole === 'tentor') {
                return allTours['tentor'] || [];
            }

            const path = window.location.pathname;

            if (path.includes('/jadwal-kelompoks')) {
                return allTours['jadwal-kelompoks'] || [];
            } else if (path.includes('/siswas')) {
                return allTours['siswas'] || [];
            } else if (path.includes('/pendaftarans')) {
                return allTours['pendaftarans'] || [];
            } else if (path.includes('/rekap-pembayarans') || path.includes('/pembayarans')) {
                return allTours['rekap-pembayarans'] || [];
            } else if (path.includes('/kelompoks')) {
                return allTours['kelompoks'] || [];
            } else {
                return allTours['dashboard'] || [];
            }
        }

        window.startPelitaTour = function(force = false) {
            const currentSteps = getTourStepsForCurrentPage();
            if (typeof window.initPelitaOnboarding === 'function') {
                window.initPelitaOnboarding(currentSteps, force);
            } else {
                setTimeout(() => {
                    if (typeof window.initPelitaOnboarding === 'function') {
                        window.initPelitaOnboarding(currentSteps, force);
                    }
                }, 300);
            }
        };

        if (shouldAutoStart) {
            setTimeout(() => {
                window.startPelitaTour(false);
            }, 800);
        }
    });
</script>
