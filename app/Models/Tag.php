<?php

namespace App\Models;

use App\Traits\Followable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    use HasFactory, Sluggable, Followable;

    protected $fillable = ['name'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    /**
     * used to fetch most used tags in specific date period.
     *
     * @param int $limit
     * @param Date $from
     * @param Date $to
     * @return \Illuminate\Database\Query\Builder
     */
    public static function popularTags($limit = -1, $from = null, $to = null)
    {

        $query = DB::table('article_tag')
            ->selectRaw('count(`tag_id`) as `tag_count`, `tag_id`, `tags`.`name`, `tags`.`slug`')
            ->groupBy(['tag_id'])
            ->orderBy('tag_count', 'desc');

        if (isset($from) && isset($to)) {
            $query->whereBetween('article_tag.created_at', [$from, $to]);
        } elseif (isset($from)) {
            $query->where('article_tag.created_at', '>=', $from);
        } elseif (isset($to)) {
            $query->where('article_tag.created_at', '<=', $to);
        }

        if ($limit > 0) {
            $query->limit($limit);
        }

        $query->join('tags', 'article_tag.tag_id', '=', 'tags.id');

        return $query;
    }

    /**
     * parses string of tags to array of tags ids
     */
    public static function parseTagString($tag_string) : array
    {
        $tags = [];
        foreach (explode(',', $tag_string) as $item) {
            $tags[] = self::firstOrCreate(['name' => trim($item)])->id;
        }
        return $tags;
    }

    public static function parseTagStringWithoutCreate($tag_string) : array
    {
        $tags = [];
        foreach (explode(',', $tag_string) as $item) {
            $tags[] = self::where('name',trim($item))->first()->id;
        }
        return $tags;
    }

    /**
     * tag article relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

}
