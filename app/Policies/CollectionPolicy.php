<?php

namespace App\Policies;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectionPolicy
{
    use HandlesAuthorization;

    /** Determine whether the user can see index page */
    public function see(User $user): bool
    {
        return ($user->hasRole([User::ADMIN, User::MANAGER, User::EDITOR]));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->hasRole([User::ADMIN, User::MANAGER]));
    }

    /** specifies user can add an article to collection */
    public function add(User $user)
    {
        return ($user->hasRole([User::ADMIN, User::MANAGER, User::EDITOR]));
    }

}
