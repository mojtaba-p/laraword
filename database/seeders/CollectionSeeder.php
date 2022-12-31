<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collection::factory()->create(['name' => "Editor's Pick"]);
        Collection::factory()->create(['name' => "2022 Selective"]);
        Collection::factory()->create(['name' => "2022 Top Laravel"]);
        Collection::factory(5)->create();
        Collection::all()->each(function ($collection){
           $collection->articles()->sync(Article::inRandomOrder()->take(10)->get());
        });
    }
}
