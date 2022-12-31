<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleComment>
 */
class ArticleCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $attributes['body'] = fake()->sentence;

        $attributes['article_id'] = Article::count() > 0
            ? Article::inRandomOrder()->take(1)->pluck('id')->first()
            : Article::factory()->create()->id;

        if(!auth()->check()){
            $attributes['user_id'] = User::count() > 0
                ? User::inRandomOrder()->take(1)->pluck('id')->first()
                : User::factory()->create()->id;
        }

        $attributes['created_at'] = now()->subDays(rand(1,20));

        return $attributes;

    }
}
