<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageLikesTest extends TestCase
{
    Use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_like_an_article()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $article = Article::factory()->create();

        $this->post(route('likes.handle.article', $article));
        $article->refresh();

        $this->assertEquals($article->likes_count, 1);
        $this->assertEquals($article->likes->count(), 1);
    }

    /** @test */
    public function authenticated_user_can_like_a_comment()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $article = Article::factory()->create();

        $comment = ArticleComment::factory()->create(['article_id' => $article->id, 'user_id' => User::factory()->create()]);

        $this->post(route('likes.handle.comment', $comment));
        $comment->refresh();

        $this->assertEquals($comment->likes_count, 1);
        $this->assertEquals($comment->likes->count(), 1);
    }

}
