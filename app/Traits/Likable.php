<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait Likable
{

    /**
     * adds like to object by given user.
     *
     * @param User $user
     * @return Model
     */
    public function addLike(User $user)
    {
        return $this->likes()->create(['user_id' => $user->id]);
    }

    /**
     * remove like from subject.
     *
     * @param User $user
     * @return void
     */
    public function unLike(User $user)
    {
        optional($this->likes()->where('user_id', $user->id)->first())->delete();
    }

    /**
     * checks that is liked by the given user.
     *
     * @param User $user
     * @return bool
     */
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * return current authenticated user liked items.
     *
     * @return mixed
     */
    public function likedByAuthUser(){
        return $this->likes()->where('user_id', auth()->user()->id)->all();
    }

    /**
     * relationship between like and object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

}
