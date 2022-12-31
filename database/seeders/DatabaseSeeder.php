<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\ArticleCommentFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategoryAndArticleSeeder::class);
        $this->call(ArticleCommentSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(CollectionSeeder::class);
    }
}
