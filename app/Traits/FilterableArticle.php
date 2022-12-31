<?php

namespace App\Traits;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * filtering and ordering methods collection
 */
trait FilterableArticle
{

    // order options for generate select input
    public static function orderOptions()
    {
        return [
            'updated_at' => __('Latest Updated'),
            'created_at' => __('Latest Created'),
            'likes_count' => __('Most Liked'),
            'comments_count' => __('Most Commented'),
            'views_count' => __('Most Viewed'),
        ];
    }

    /** filter results by given request */
    public static function scopeFilterResults(Builder $query, $request): void
    {
        if (isset($request['username']) && !empty($request['username'])) {
            $query->filterByAuthor($request['username']);
        }

        if (isset($request['tags']) && !empty($request['tags'])) {
            $query->filterByTagString($request['tags']);
        }

        if (isset($request['order']))
            $query->orderResults($request['order'], $request['sort']);
        else
            $query->orderBy('updated_at', 'desc');

        if (isset($request['title']) && !empty($request['title'])) {
            $query->where('title', 'like', "%{$request['title']}%");
        }

        if (isset($request['category_id']) && !empty($request['category_id'])) {
            $query->where('category_id', $request['category_id']);
        }
    }

    public static function scopeFilterByTagString(Builder $query, string $tags): void
    {
        $tag_ids = Tag::parseTagStringWithoutCreate($tags);
        $query->hasSimilarTags($tag_ids);
    }

    public static function scopeFilterByAuthor(Builder $query, string $author_username): void
    {
        $user = User::whereUsername($author_username)->first();
        if (isset($user)) {
            $query->where('user_id', $user->id);
        }
    }

    /**
     * sorts articles by given column
     */
    public static function scopeOrderResults(Builder $query, string $order, string $sort = 'desc'): void
    {
        if (in_array($order, ['created_at', 'updated_at', 'likes_count', 'views_count'])) {
            $query->orderBy($order, $sort);
        }
        switch ($order) {
            case 'comments_count':
                $query->withCount('comments')->orderBy('comments_count', $sort);
                break;
            default:
                break;
        }
    }

    /**
     * limits articles to the given date period
     */
    public static function scopeLimitToDate(Builder $query, string $period = null): void
    {
        if ($period == 'today') {
            $query->where('created_at', '>=', now()->subDay()->endOfDay());
        }
        if ($period == 'last_week') {
            $query->where('created_at', '>=', now()->subWeek()->endOfDay());
        }
        if ($period == 'last_month') {
            $query->where('created_at', '>=', now()->subMonth()->endOfDay());
        }
    }


    public static function scopeHasSimilarTags(Builder $query, array $tags): void
    {
        $query->with('tags')
            ->where('status', Article::STATUS_PUBLIC)
            ->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('id', $tags);
            });
    }


    /**
     * last week comments count
     */
    public function scopeLastWeekComments($query): void
    {
        $query->withCount(['comments as lw_comments_count' => function ($query) {
            $query->where('article_comments.created_at', '>=', now()->subDays(7));
        }]);
    }

    /**
     * last week likes count
     */
    public function scopeLastWeekLikes($query): void
    {
        $query->withCount(['likes as lw_likes_count' => function ($query) {
            $query->where('likes.created_at', '>=', now()->subDays(7));
        }]);
    }


    public function scopeDefaultSorting($query)
    {
        $query->lastWeekComments()
            ->lastWeekLikes()
            ->orderBy('created_at', 'desc')
            ->orderBy('lw_comments_count', 'desc')
            ->orderBy('lw_likes_count', 'desc');
    }

}
