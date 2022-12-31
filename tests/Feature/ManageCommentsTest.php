<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCommentsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function user_can_add_comment()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $article = Article::factory()->create();
        $comment = ArticleComment::factory()->raw(['created_at' => now()]);
        $this->post(route('articles.comments.store', $article), $comment);
        $this->assertDatabaseHas('article_comments', $comment + ['article_id' => $article->id]);

    }

    /** @test */
    public function comment_can_have_replay()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $article = Article::factory()->create();

        $comment_one = ArticleComment::factory()->raw();
        $this->post(route('articles.comments.store', $article), $comment_one);


        $comment_two = ArticleComment::factory()->raw();
        $this->post(route('articles.comments.store', $article), $comment_two + ['parent_id' => 1]);

        $this->assertDatabaseHas('article_comments', ['body' => $comment_two['body'], 'parent_id' => 1]);

        $comment_three = ArticleComment::factory()->raw();
        $this->post(route('articles.comments.store', $article), $comment_three + ['parent_id' => 2]);

        $this->assertDatabaseHas('article_comments', ['body' => $comment_three['body'], 'parent_id' => 2]);
        $this->assertEquals($article->comments->count(), 3);

    }

    /** @test */
    public function users_can_see_comments_in_article_page()
    {
        $article = Article::factory()->create(['category_id' => Category::factory()->create()->id, 'status' => 1]);

        $comment = $article->addComment(ArticleComment::factory()->raw());
        $reply = $comment->addReply(ArticleComment::factory()->raw());

        $this->get(route('articles.show', $article))
            ->assertSee([$comment->body, $reply->body]);

    }


}
