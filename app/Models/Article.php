<?php

namespace App\Models;

use App\Traits\FilterableArticle;
use App\Traits\HasImage;
use App\Traits\Likable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stevebauman\Purify\Casts\PurifyHtmlOnSet;

class Article extends Model
{
    use HasFactory, Sluggable, Likable, FilterableArticle, HasImage;

    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLIC = 1;

    protected $guarded = [];
    protected $casts = ['content' => PurifyHtmlOnSet::class];
    protected $with = ['category', 'author'];
    protected $withCount = ['comments'];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * increase views count of article.
     */
    public function seen():void
    {
        $session_key = $this->slug . '_viewed';
        if (!session()->exists($session_key)) {
            session([$session_key => now()]);
            $this->timestamps = false;
            $this->increment('views_count');
            $this->timestamps = true;
        }
    }

    public function markAsPinned(): void
    {
        $this->pinned_at = now();
        $this->save();
    }

    public function syncTags($tags): void
    {
        if ($tags)
            $this->tags()->sync(Tag::parseTagString($tags));
        else
            $this->tags()->sync([]);
    }

    /**
     * adds comment to current article.
     *
     */
    public function addComment(array $comment): Model
    {
        return $this->comments()->create($comment);
    }

    /**
     * calculates reading time of article.
     */
    public function readingTime(): float
    {
        $time = round((str_word_count($this->title) + str_word_count(strip_tags($this->content))) / 200);
        return ($time > 0) ? $time : 1;
    }

    /**
     * generates title of page and meta tag
     */
    public function getTitle(): string
    {
        if (isset($this->meta_title)) {
            return $this->meta_title;
        }

        return "{$this->title} | by {$this->author->name}";
    }

    /**
     * generates description for meta tag
     */
    public function getDescription(): string
    {
        if (isset($this->meta_description)) {
            return $this->meta_description;
        }

        return Str::limit(strip_tags($this->content), 160, '.');
    }

    /**
     * returns current article comments with replies of them
     */
    public function getComments(): mixed
    {
        return $this->comments()->with('writer')->latest()->get()->parsed();
    }

    /**
     * fetch related articles and sort by tags intersect
     */
    public function relatedArticles(): \Illuminate\Database\Eloquent\Collection
    {
        $tags = $this->tags()->pluck('id')->toArray();

        return self::where('id', '!=', $this->id)
            ->hasSimilarTags($tags)
            ->get()
            ->sortByDesc(function ($relatedArticle) use ($tags) {
                return $relatedArticle->tags->pluck('id')->intersect($tags)->count();
            });
    }

    /**
     * returns path to the thumbnail by given size.
     */
    public function thumbnailPath(int $size = null): mixed
    {
        if (isset($size)) {
            return $this->author->mediaPath($size . $this->thumbnail);
        }

        return $this->author->mediaPath($this->thumbnail);
    }


    /**
     * format time if article older than 1 year show complete date.
     */
    public function articleDate(): mixed // @todo better name
    {
        return $this->created_at->diffInYears(now()) == 0 ? $this->created_at->format('M d') : $this->created_at->format('y/m/d');
    }

    /**
     * changes status of article.
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function contentSummary(int $length = 160): string
    {
        return Str::limit(strip_tags($this->content), $length);
    }

    /**
     * specifies article is published or not
     */
    public function isPublished(): bool
    {
        return $this->status == self::STATUS_PUBLIC;
    }

    /**
     * articles and users relationship.
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * tags relationship.
     */
    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }


    /**
     * Article Category relationship.
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * article and comment relationship.
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

}
