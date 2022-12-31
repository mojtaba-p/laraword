<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $likables = [Article::class, ArticleComment::class];
        return [
            'user_id' => rand(1, 100),
            'likable_type' => $likables[rand(0,1)],
            'likable_id' => rand(1,200),
            'created_at' => now()->subDays(rand(1,20))
        ];
    }
}
