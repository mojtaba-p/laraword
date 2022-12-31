<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users_count = User::count();
        $attributes = [];
        if( $users_count > 0)
            $attributes['user_id'] = User::inRandomOrder()->take(1)->pluck('id')->first();
        else
            $attributes['user_id'] = User::factory()->create();

        $date = now()->subDays(rand(1, 30));
        $attributes += [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(50),
            'status' => 1,
            'created_at' => $date,
            'updated_at' => $date,
        ];

        return $attributes;
    }
}
