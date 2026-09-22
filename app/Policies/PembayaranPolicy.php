<?php

namespace App\Policies;

use App\Models\Pembayaran;
use App\Models\User;

class PembayaranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Pembayaran $pembayaran): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Pembayaran $pembayaran): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Pembayaran $pembayaran): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
