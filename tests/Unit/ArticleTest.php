<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function article_can_have_tags()
    {
        $this->signIn();
        $article = Article::factory()->create();
        $tag = Tag::factory()->create();

        $article->tags()->attach($tag);

        $this->assertEquals($tag->name, $article->tags->first()->name);
    }

    /** @test */
    public function article_have_category()
    {
        $category = Category::factory()->create();
        $article = Article::factory()->create(['category_id' => $category->id]);

        $this->assertEquals($article->category->name, $category->name);
    }

    /** @test */
    public function article_have_reading_time()
    {
        $article = Article::factory()->create();

        $total_words = str_word_count($article->title .' '. $article->content);

        $this->assertEquals(round($total_words/200), $article->readingTime());
    }


    /** @test */
    public function article_can_have_comments()
    {
        $this->signIn();
        $article = Article::factory()->create();
        $comment = ArticleComment::factory()->raw();

        $article->addComment($comment + ['user_id' => auth()->id()]);

        $this->assertEquals(1, $article->comments->count());
    }

    /** @test */
    public function article_have_a_slug()
    {
        $article = Article::factory()->create(['title' => 'lorem ipsum dom']);
        $this->assertEquals('lorem-ipsum-dom', $article->slug);

        $article = Article::factory()->create(['title' => 'lorem ipsum dom']);
        $this->assertEquals('lorem-ipsum-dom-2', $article->slug);

    }

    /** @test */
    public function article_can_liked_by_user()
    {
        $this->signIn();
        $article = Article::factory()->create();
        $article->addLike(auth()->user());

        $article->refresh();

        $this->assertEquals($article->likes_count, 1);
        $this->assertDatabaseHas('likes',
            ['likable_type' => Article::class, 'likable_id' => $article->id, 'user_id' => auth()->id()]
        );
    }

    /** @test */
    public function article_can_unlike_by_user()
    {
        $this->signIn();

        $article = Article::factory()->create();
        $article->addLike(auth()->user());

        $this->assertTrue($article->isLikedBy(auth()->user()));

        $article->unLike(auth()->user());
        $this->assertFalse($article->isLikedBy(auth()->user()));

    }

    /** @test */
    public function article_has_status()
    {
        $this->signIn();

        $article = Article::factory()->create();

        $article->setStatus(Article::STATUS_DRAFT);
        $this->assertEquals($article->status, Article::STATUS_DRAFT);

        $article->setStatus(Article::STATUS_PUBLIC);
        $this->assertEquals($article->status, Article::STATUS_PUBLIC);
    }

    /** @test */
    public function article_has_view_count()
    {
        $article = Article::factory()->create(['status' => 1]);
        $this->assertEquals($article->view_count, 0);
    }

    /** @test */
    public function article_can_mark_as_pinned()
    {
        $this->signIn();
        $article = Article::factory()->create();

        $article->markAsPinned();
        $this->assertEquals($article->id, Article::whereNotNull('pinned_at')->orderBy('created_at','desc')->first()->id);
    }


}
