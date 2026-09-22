<?php

namespace App\Policies;

use App\Models\Pendaftaran;
use App\Models\User;

class PendaftaranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Pendaftaran $pendaftaran): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Pendaftaran $pendaftaran): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Pendaftaran $pendaftaran): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
