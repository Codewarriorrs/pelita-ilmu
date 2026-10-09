<?php

namespace App\Policies;

use App\Models\JadwalKelompok;
use App\Models\User;

class JadwalKelompokPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isTentor();
    }

    public function view(User $user, JadwalKelompok $jadwalKelompok): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isTentor() && $jadwalKelompok->kelompok?->tentor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, JadwalKelompok $jadwalKelompok): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isTentor() && $jadwalKelompok->kelompok?->tentor_id === $user->id;
    }

    public function delete(User $user, JadwalKelompok $jadwalKelompok): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
