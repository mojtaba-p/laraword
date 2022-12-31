<?php

namespace App\Models;

use App\Http\Collections\ArticleCommentCollection;
use App\Traits\Likable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    use HasFactory, Likable;

    protected $fillable = ['body', 'user_id', 'parent_id', 'article_id'];

    /**
     * adds reply to current comment.
     *
     * @param $comment
     * @return Model
     */
    public function addReply($comment)
    {
        return $this->replies()->create($comment + ['article_id' => $this->article_id]);
    }


    /**
     * comment and user relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function writer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relationship between comment and replied comment to that
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(ArticleComment::class, 'parent_id')->with('replies');
    }

    // relationship
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return ArticleCommentCollection
     */
    public function newCollection(array $models = [])
    {
        return new ArticleCommentCollection($models);
    }
}
