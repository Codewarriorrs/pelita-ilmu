<?php

namespace App\Policies;

use App\Models\DetailPresensi;
use App\Models\User;

class DetailPresensiPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isTentor();
    }

    public function view(User $user, DetailPresensi $detailPresensi): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isTentor() && $detailPresensi->jadwal?->kelompok?->tentor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isTentor();
    }

    public function update(User $user, DetailPresensi $detailPresensi): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isTentor() && $detailPresensi->jadwal?->kelompok?->tentor_id === $user->id;
    }

    public function delete(User $user, DetailPresensi $detailPresensi): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
