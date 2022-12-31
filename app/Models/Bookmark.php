<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bookmark extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function boxes():BelongsToMany
    {
        return $this->belongsToMany(Box::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
