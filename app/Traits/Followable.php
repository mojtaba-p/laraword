<?php

namespace App\Traits;

use App\Models\Follow;
use App\Models\User;

trait Followable
{
    /**
     * adds follower to followable subject.
     */
    public function addFollower(User $user) :  \Illuminate\Database\Eloquent\Model
    {
        return $this->followers()->create(['user_id' => $user->id]);
    }

    /**
     * removes follower from followable subject.
     */
    public function removeFollower(User $user) : mixed
    {
        return optional($this->followers()->where('user_id', $user->id)->first())->delete();
    }

    /**
     * relationship between followable and follows table.
     */
    public function followers() :\Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function followersCount(): string
    {
        return $this->shortNumber($this->followers->count());
    }

    // by: https://stackoverflow.com/users/112332/justin-vincent
    function shortNumber($num) : string
    {
        $units = ['', 'K', 'M', 'B', 'T'];
        for ($i = 0; $num >= 1000; $i++) {
            $num /= 1000;
        }
        return round($num, 1) . $units[$i];
    }
}
