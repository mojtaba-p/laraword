<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function see(User $user) : bool
    {
        return ($user->hasRole(User::MANAGER) || $user->hasRole(User::ADMIN));
    }

    public function updateRole(User $user): bool
    {
        return ($user->hasRole(User::MANAGER) || $user->hasRole(User::ADMIN));
    }
}
