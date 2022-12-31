<?php

namespace Database\Seeders;

use App\Models\ArticleComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleComment::factory(100)
            ->has(ArticleComment::factory()->state(function (array $attr,ArticleComment $comment){
                return ['article_id' => $comment->article_id];
            }), 'replies')->create();

    }
}
