<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class BloodDonorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isPerawat();
    }

    public function view(User $user): bool
    {
        return $user->isAdmin() || $user->isPerawat();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isPerawat();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin() || $user->isPerawat();
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }
}
