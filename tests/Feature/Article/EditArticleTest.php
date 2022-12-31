<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_article_edit_page()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $article = Article::factory()->create();

        $this->get(route('dashboard.articles.edit', $article))
            ->assertSee($article->title)
            ->assertSee($article->content);
    }

    /** @test */
    public function user_can_update_article()
    {
        $this->signIn();

        $article = Article::factory()->create();
        $category = Category::factory()->create();

        $new_attributes = ['title' => 'something else', 'content' => 'other content', 'category_id' => $category->id];

        tap($new_attributes, function ($attributes) use ($article) {
            $attributes['tags'] = 'tag1, tag 2 , tag is here 3';
            $this->put(route('dashboard.articles.update', $article), $attributes)
                ->assertRedirect(route('dashboard.articles.index'));
            $last_tag = Tag::whereName('tag is here 3')->first();

            $this->assertTrue(Article::first()->tags->contains($last_tag));
        });

        $this->assertDatabaseHas('articles', $new_attributes);

    }


    /** @test */
    public function users_cant_see_article_edit_page_of_others()
    {
        $this->signIn();
        $article = Article::factory()->create();

        $this->signIn();
        $this->get(route('dashboard.articles.edit', $article))
            ->assertStatus(404);
    }

    /** @test */
    public function users_cant_update_others_article()
    {
        $this->signIn();
        $article = Article::factory()->create();

        $this->signIn();
        $new_attributes = ['title' => 'invalid', 'content' => 'something else'];

        $this->put(route('dashboard.articles.update', $article), $new_attributes)
            ->assertStatus(403);
    }

    /** @test */
    public function author_can_customize_meta_attributes()
    {

        $this->signIn();
        $article_attributes = Article::factory()->create()->getAttributes();

        $meta_attributes = [
            'meta_title' => 'custom meta title',
            'meta_description' => 'custom meta description',
        ];

        $article_attributes['updated_at'] = now();

        $article = array_merge($article_attributes, $meta_attributes);

        $this->put(route('dashboard.articles.update', $article_attributes['slug']),  $article);

        $this->assertDatabaseHas('articles', $article);
    }


}
