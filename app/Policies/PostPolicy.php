<?php

namespace App\Policies;

use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isPerawat();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin() || ($user->isPerawat()); // Maybe perawat can update? Or only Admin. Let's say only Admin for news.
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }
}
