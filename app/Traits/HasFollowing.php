<?php

namespace App\Traits;

use App\Models\Follow;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait HasFollowing
{
    /**
     * returns records that user followed
     */
    public function followings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Follow::class);
    }

    /**
     * return users ids that current user followed them
     */
    public function followingUsers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->followings()->where('followable_type', User::class);
    }

    /**
     * return tags ids that current user followed them
     */
    public function followingTopics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->followings()->where('followable_type', Tag::class);
    }

    // Determine is followed by user or not
    public function doesFollow(Model $followable): bool
    {
        return $this->followings()->where('followable_id' , $followable->id)
            ->where('followable_type', get_class($followable))->exists();
    }

}
