<?php

namespace App\Providers;

use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(\App\Models\Kelompok::class, \App\Policies\KelompokPolicy::class);
        Gate::policy(\App\Models\Siswa::class, \App\Policies\SiswaPolicy::class);
        Gate::policy(\App\Models\Pembayaran::class, \App\Policies\PembayaranPolicy::class);
        Gate::policy(\App\Models\Pendaftaran::class, \App\Policies\PendaftaranPolicy::class);
        Gate::policy(\App\Models\MataPelajaran::class, \App\Policies\MataPelajaranPolicy::class);
        Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
