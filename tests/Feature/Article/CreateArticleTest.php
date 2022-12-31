<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_article_create_page()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $this->get(route('dashboard.articles.create'))->assertOk();
    }

    /** @test */
    public function user_can_create_article()
    {
        $this->signIn();

        $category = Category::factory()->create();

        $article = [
            'title' => 'Some Articles Title',
            'content' => 'some text for the this article must goes here.',
            'category_id' => $category->id
        ];

        tap($article, function ($article) {
            $article['tags'] = $this->getTags();
            $this->post('dashboard/articles', $article)->assertRedirect('/dashboard/articles');
            $this->assertEquals(Article::first()->tags->count(), 3);
        });

        $this->assertDatabaseHas('articles', $article);

    }

    /** @test */
    public function article_requires_title()
    {
        $this->signIn();

        $article = [
            'title' => '   ',
        ];
        $this->post('dashboard/articles', $article)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function article_status_can_publish_on_create()
    {
        $this->signIn();

        $article = [
            'title' => 'Some Articles Title',
            'content' => 'some text for the this article must goes here.',
            'status' => 'publish'
        ];

        $this->post('dashboard/articles', $article);
        $this->assertDatabaseHas('articles', array_merge($article, ['status' => 1]));

    }


}
