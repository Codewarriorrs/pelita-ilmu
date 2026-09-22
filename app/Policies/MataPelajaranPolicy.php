<?php

namespace App\Policies;

use App\Models\MataPelajaran;
use App\Models\User;

class MataPelajaranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, MataPelajaran $mapel): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, MataPelajaran $mapel): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, MataPelajaran $mapel): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
