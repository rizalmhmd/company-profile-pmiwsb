<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    /**
     * Determine if user is admin
     */
    public function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user is perawat
     */
    public function isPerawat(User $user): bool
    {
        return $user->isPerawat();
    }
}
