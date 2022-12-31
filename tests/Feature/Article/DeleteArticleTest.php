<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_an_article()
    {
        $this->signIn();
        $article = Article::factory()->create();

        $this->delete(route('dashboard.articles.destroy', $article))->assertStatus(204);
        $this->assertDatabaseMissing('articles', ['title' => $article->title]);
    }
}
