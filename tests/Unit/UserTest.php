<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_have_role()
    {
        $user = User::factory()->create();

        $user->setRole(User::ADMIN);
        Config::set('laraword.admins', [$user->email]);

        $this->assertTrue($user->hasRole(User::ADMIN));

        $this->expectExceptionMessage('INVALID ROLE');

        $user->setRole('super admin');
    }

    /** @test */
    public function user_can_have_articles()
    {
        $user = User::factory()->create();
        $articles = Article::factory(5)->create(['user_id' => $user->id]);

        $this->assertEquals(5, $user->articles->count());
    }

    /** @test */
    public function user_can_like_comment()
    {
        $user = User::factory(2)->create()->first();
        $comment = ArticleComment::factory()->create();

        $comment->addLike($user);
        $this->assertEquals(1, $comment->likes->count());

        $this->assertEquals($user->likes->first()->likable, ArticleComment::first());
    }

    /** @test */
    public function user_can_like_article()
    {
        $user = User::factory(2)->create()->last();
        $article = Article::factory()->create();

        $article->addLike($user);
        $this->assertEquals(1, $article->likes->count());

        $this->assertEquals($user->likes->first()->likable, Article::first());
    }

    /** @test */
    public function user_have_unique_media_directory()
    {
        [$user1, $user2] = User::factory(2)->create();
        $this->assertNotEquals($user1->mediaDir(), $user2->MediaDir());
    }

    /** @test */
    public function user_have_bookmarks()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();
        $user->bookmarks()->create(['article_id' => $article->id]);
        $this->assertEquals(1, $user->bookmarks->count());
    }

    /** @test */
    public function user_can_add_bookmark_to_box()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();
        $bookmark = $user->bookmarks()->create(['article_id' => $article->id]);
        $box = $user->boxes()->create(['name' => 'new box']);
        $box->bookmarks()->attach($bookmark);
        $this->assertEquals(1, $box->bookmarks->count());
        $this->assertTrue($box->bookmarks->contains($bookmark));
    }


}
