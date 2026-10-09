<?php

namespace App\Policies;

use App\Models\Siswa;
use App\Models\User;

class SiswaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isTentor();
    }

    public function view(User $user, Siswa $siswa): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTentor()) {
            return $siswa->kelompok()->where('tentor_id', $user->id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Siswa $siswa): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
