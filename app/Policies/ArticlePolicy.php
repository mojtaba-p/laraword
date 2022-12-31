<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function seeAll(User $user): bool
    {
        return $user->hasRole([User::ADMIN, User::MANAGER, User::EDITOR]);
    }

    /**
     * Determine whether the user can edit the model.
     */
    public function edit(User $user, Article $article): \Illuminate\Auth\Access\Response|bool
    {
        return $article->author()->is($user)
            ? Response::allow()
            : Response::denyWithStatus(404);
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): \Illuminate\Auth\Access\Response|bool
    {
        return $article->author()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): \Illuminate\Auth\Access\Response|bool
    {
        return $article->author()->is($user);
    }

}
