<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Box;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_bookmark_an_article()
    {
        $article = Article::factory()->create();
        $this->signIn();
        $box = auth()->user()->boxes()->first();
        $request = ['boxes' => [$box->slug]];
        $this->post(route('dashboard.articles.bookmark.store', $article), $request)->assertStatus(200);
        $this->assertDatabaseHas('bookmarks', ['article_id' => $article->id, 'user_id' => auth()->id()]);
    }

    /** @test */
    public function user_can_remove_a_bookmark()
    {
        $article = Article::factory()->create();
        $this->signIn();
        $bookmark = Bookmark::factory()->create(['user_id' => auth()->id()]);
        [$box1, $box2] = Box::factory(2)->create();
        $bookmark->boxes()->sync([$box1->id, $box2->id]);
        $this->post(route('dashboard.articles.bookmark.store', $article))->assertStatus(200);
        $this->assertDatabaseMissing('bookmarks', ['article_id' => $article->id, 'user_id' => auth()->id()]);
        $this->assertDatabaseMissing('bookmark_box', ['bookmark_id' => $article->id, 'box_id' => $box1->id]);
        $this->assertDatabaseMissing('bookmark_box', ['bookmark_id' => $article->id, 'box_id' => $box2->id]);

    }

    /** @test */
    public function user_can_see_what_boxes_are_bookmarks_in()
    {
        $this->signIn();
        $bookmark = Bookmark::factory()->create(['user_id' => auth()->id()]);
        $box = Box::factory()->create();
        $box->bookmarks()->attach($bookmark);
        $this->get(route('dashboard.bookmark.boxes', $bookmark))
            ->assertsee($box->slug)
            ->assertStatus(200);
    }

    /** @test */
    public function bookmarks_can_be_seen_in_box_page()
    {
        $user = User::factory()->create();
        $bookmark = Bookmark::factory()->create(['user_id' => $user->id]);
        $box = Box::factory()->create(['user_id' => $user->id]);
        $box->bookmarks()->attach($bookmark);

        $this->get(route('users.boxes.show', ['user' => $user, 'box' => $box]))
            ->assertSee($bookmark->article->title)
            ->assertStatus(200);

    }


}
