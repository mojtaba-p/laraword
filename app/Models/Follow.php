<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    /** relationship */
    public function followable()
    {
        return $this->morphTo();
    }

    /** relationship */
    public function users()
    {
        return $this->morphedByMany(User::class, 'followable');
    }

    /** relationship */
    public function topics()
    {
        return $this->morphedByMany(Tag::class, 'followable');
    }
}
