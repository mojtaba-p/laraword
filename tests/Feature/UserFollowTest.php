<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFollowTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_follow_other_users()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->has(Article::factory(5))->create();
        $follower = User::factory()->create();

        $this->actingAs($follower)->post(route('follow.store.user'), ['username' => $user->username]);

        $follower->refresh();
        $this->assertTrue($follower->doesFollow($user));
        $this->post(route('follow.show'), ['username' => $user->username])->assertContent('true');
    }

    /** @test */
    public function user_can_unfollow_other_users()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->has(Article::factory(5))->create();
        $follower = User::factory()->create();

        $this->actingAs($follower)->post(route('follow.store.user'), ['username' => $user->username]); // follow

        $this->actingAs($follower)->post(route('follow.store.user'), ['username' => $user->username]); // unfollow

        $this->assertTrue(!$follower->doesFollow($user));
        $this->post(route('follow.show'), ['username' => $user->username])->assertContent('false');
    }

    /** @test */
    public function user_can_follow_tags()
    {
        $this->withoutExceptionHandling();
        $tag = Tag::factory()->create();
        $follower = User::factory()->create();

        $this->actingAs($follower)->post(route('follow.store.topic'), ['tag' => $tag->slug]);

        $follower->refresh();

        $this->assertTrue($follower->doesFollow($tag));

        $this->post(route('follow.show'), ['tag' => $tag->slug])->assertContent('true');
    }

    /** @test */
    public function user_can_unfollow_tags()
    {
        $this->withoutExceptionHandling();
        $tag = Tag::factory()->create();
        $follower = User::factory()->create();

        $this->actingAs($follower)->post(route('follow.store.topic'), ['tag' => $tag->slug]); // follow

        $this->actingAs($follower)->post(route('follow.store.topic'), ['tag' => $tag->slug]); // unfollow

        $this->assertTrue(!$follower->doesFollow($tag));

        $this->post(route('follow.show'), ['tag' => $tag->slug])->assertContent('false');
    }

    /** @test */
    public function user_see_interest_selecting_page_if_doesnt_follow_anything()
    {
        $this->signIn();
        Article::factory()->has(Tag::factory())->create();
        $this->get(route('dashboard'))
            ->assertSee(__('Select your interested topics'));
    }

    /** @test */
    public function user_can_save_interest()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $tags = Tag::factory(10)->create();
        $tags_slugs = $tags->pluck('slug')->toArray();
        $tags_titles = $tags->pluck('titles')->toArray();

        $this->post(route('follow.store.interest'), ['interested_topics' => $tags_slugs])
            ->assertRedirect(route('dashboard'));

        $this->assertEquals(auth()->user()->followings()->pluck('id'), $tags->pluck('id'));

        $this->get(route('dashboard'))->assertSee($tags_titles);
    }


    /** @test */
    public function user_can_see_followed_users_articles_in_dashboard()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $user = User::factory()->has(Article::factory(5))->create();

        $this->post(route('follow.store.user'), ['username' => $user->username]);

        $expected_feed_articles = $user->articles->pluck('title')->toArray();

        $this->get(route('dashboard').'?following')->assertSee($expected_feed_articles);
    }

    /** @test */
    public function user_can_see_followed_topics_articles_in_dashboard()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $tag = Tag::factory()->has(Article::factory(5))->create();
        $user = User::factory()->has(Article::factory(5))->create();

        $this->post(route('follow.store.user'), ['username' => $user->username]);

        $this->post(route('follow.store.topic'), ['tag' => $tag->slug]);

        $expected_feed_articles = $tag->articles->pluck('title')->toArray();

        $this->get(route('dashboard', ['topic' => $tag->slug]))->assertSee($expected_feed_articles);

    }

}
