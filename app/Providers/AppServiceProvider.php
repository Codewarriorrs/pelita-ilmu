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
        Gate::policy(\App\Models\JadwalKelompok::class, \App\Policies\JadwalKelompokPolicy::class);
        Gate::policy(\App\Models\DetailPresensi::class, \App\Policies\DetailPresensiPolicy::class);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // [TEMPORARY MEASUREMENT] Pelacak query lambat > 100ms (SQL tanpa binding)
        \Illuminate\Support\Facades\DB::listen(function ($query) {
            if ($query->time > 100) {
                file_put_contents(
                    'php://stderr',
                    sprintf("[SLOW_QUERY] Time: %.2f ms | SQL: %s%s", $query->time, $query->sql, PHP_EOL)
                );
            }
        });

        // [TEMPORARY MEASUREMENT] Deteksi N+1 di non-production
        \Illuminate\Database\Eloquent\Model::preventLazyLoading(! app()->isProduction());
    }
}
