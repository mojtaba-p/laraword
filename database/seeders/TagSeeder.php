<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory()->count(30)->create();
        Article::all()->each(function ($article){
           $article->tags()->sync(Tag::inRandomOrder()->take(rand(1,4))->get());
        });

        // randomize article tags created at column
        DB::table('article_tag')->orderBy('created_at')->each(function ($record) {
            DB::table('article_tag')->where('article_id', $record->article_id)->update(['created_at' => now()->subDays(rand(1, 30))]);
        });
    }
}
