<?php

namespace App\Policies;

use App\Models\Kelompok;
use App\Models\User;

class KelompokPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isTentor();
    }

    public function view(User $user, Kelompok $kelompok): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isTentor() && $kelompok->tentor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Kelompok $kelompok): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Kelompok $kelompok): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
