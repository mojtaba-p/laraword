<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if(Article::count() < 1){
            Article::factory()->create();
        }
        if(User::count() < 1){
            User::factory()->create();
        }

        return [
            'user_id' => mt_rand(1, User::count()),
            'article_id' => mt_rand(1, Article::count())
        ];
    }
}
