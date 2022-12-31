<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Tag;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function createTags()
    {
        Article::factory(100)->create();
        $tags = Tag::factory()->count(3)->create();

        for ($i=1; $i <= 100; $i++){
            if($i <= 45)
                Article::find($i)->tags()->sync($tags->find(1));
            elseif($i <= 60)
                Article::find($i)->tags()->sync($tags->find(2));
            else
                Article::find($i)->tags()->sync($tags->find(3));
        }
    }

    /** @test */
    public function tag_has_popular_list()
    {
        $this->createTags();
        $tags = Tag::popularTags();

        $this->assertEquals(
            [1 => 45, 3 => 40, 2 => 15],
            $tags->get()->pluck('tag_count', 'tag_id')->toArray()
        );
    }

    /** @test */
    public function popular_tag_list_can_limit_by_created_at()
    {
        $this->createTags();
        DB::table('article_tag')
            ->update([ 'created_at' => now()->subDays(30) ]);

        DB::table('article_tag')
            ->where('tag_id', 1)
            ->where('article_id', '>', 40)
            ->update([ 'created_at' => now()->subDays(3) ]);

        DB::table('article_tag')
            ->where('tag_id', 2)
            ->where('article_id', '>', 50)
            ->update([ 'created_at' => now()->subDays(6) ]);

        DB::table('article_tag')
            ->where('tag_id', 3)
            ->where('article_id', '>', 90)
            ->update([ 'created_at' => now()->subDays(5) ]);

        $tags = Tag::popularTags(5, now()->subDays(7));

        $this->assertEquals(
            [1 => 5, 3 => 10, 2 => 10],
            $tags->get()->pluck('tag_count', 'tag_id')->toArray()
        );
    }


}
