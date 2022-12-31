<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function collection_has_many_articles()
    {
        $collection = Collection::factory()->create();
        $articles = Article::factory(10)->create(['status' => 1]);

        $collection->articles()->sync($articles);

        $this->assertCount(10, $collection->articles);
    }

}
