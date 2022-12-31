<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    Use RefreshDatabase;

    /** @test */
    public function can_have_replies()
    {
        $this->signIn();

        $article = Article::factory()->create();

        $comment_one = $article->addComment(ArticleComment::factory()->raw() + ['user_id' => auth()->id()]);

        $this->signIn();
        $reply = ArticleComment::factory()->raw();
        $comment_one->addReply($reply + ['user_id' => auth()->id()]);

        $this->assertEquals($comment_one->replies->first()->body, $reply['body']);
    }

}
