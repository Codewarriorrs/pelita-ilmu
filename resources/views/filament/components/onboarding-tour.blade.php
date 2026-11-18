@php
    $user = filament()->auth()->user();
    $role = $user && $user->hasRole('tentor') ? 'tentor' : 'admin';
    $steps = config("onboarding.{$role}", []);
    $shouldAutoStart = session()->pull('show_onboarding_tour', false) && !($user->hide_onboarding_tour ?? false);
@endphp

@vite(['resources/js/onboarding.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tourSteps = @json($steps);
        const shouldAutoStart = @json($shouldAutoStart);

        window.startPelitaTour = function(force = false) {
            if (typeof window.initPelitaOnboarding === 'function') {
                window.initPelitaOnboarding(tourSteps, force);
            } else {
                setTimeout(() => {
                    if (typeof window.initPelitaOnboarding === 'function') {
                        window.initPelitaOnboarding(tourSteps, force);
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
