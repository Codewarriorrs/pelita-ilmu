<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as BaseAuthenticate;

class FilamentAuthenticate extends BaseAuthenticate
{
    /**
     * Redirect unauthenticated users to the custom /login route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        return route('login');
    }
}
