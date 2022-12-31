<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function manager_can_order_users_by_articles_count()
    {
        $user1 = User::factory()->has(Article::factory(10))->create();
        $user2 = User::factory()->has(Article::factory(1))->create();
        $user3 = User::factory()->has(Article::factory(5))->create();
        $user4 = User::factory()->has(Article::factory(20))->create();

        $this->signIn(User::MANAGER);
        $request = [
            'order' => 'articles_count',
            'sort' => 'desc'
        ];

        $this->get(route('management.users.index', $request))->assertSeeInOrder(
            [$user4->name, $user1->name, $user3->name, $user2->name]
        );

    }

    /** @test */
    public function manager_can_order_users_by_verification_date()
    {
        $user1 = User::factory()->create(['email_verified_at' => now()->subDay(1)]);
        $user2 = User::factory()->create(['email_verified_at' => now()->subDay(10)]);
        $user3 = User::factory()->create(['email_verified_at' => now()->subDay(2)]);
        $user4 = User::factory()->create(['email_verified_at' => now()->subDay(0)]);

        $this->signIn(User::MANAGER);

        $request = [
            'order' => 'email_verified_at',
            'sort' => 'desc'
        ];

        $this->get(route('management.users.index', $request))->assertSeeInOrder(
            [$user4->name, $user1->name, $user3->name, $user2->name]
        );
    }

    /** @test */
    public function manager_can_order_users_by_comments_count()
    {
        [$user1, $user2, $user3, $user4] = User::factory(4)->create();
        ArticleComment::factory(5)->create(['user_id' => $user1->id]);
        ArticleComment::factory(1)->create(['user_id' => $user2->id]);
        ArticleComment::factory(4)->create(['user_id' => $user3->id]);
        ArticleComment::factory(10)->create(['user_id' => $user4->id]);

        $this->signIn(User::MANAGER);

        $request = [
            'order' => 'comments_count',
            'sort' => 'desc'
        ];

        $this->get(route('management.users.index', $request))->assertSeeInOrder(
            [$user4->name, $user1->name, $user3->name, $user2->name]
        );
    }


    /** @test */
    public function manager_can_order_users_by_likes_count()
    {
        Article::factory(200)->has(ArticleComment::factory(2), 'comments')->create();
        [$user1, $user2, $user3, $user4] = User::factory(4)->create();
        Like::factory(5)->create(['user_id' => $user1->id]);
        Like::factory(1)->create(['user_id' => $user2->id]);
        Like::factory(4)->create(['user_id' => $user3->id]);
        Like::factory(10)->create(['user_id' => $user4->id]);

        $this->signIn(User::MANAGER);

        $request = [
            'order' => 'likes_count',
            'sort' => 'desc'
        ];

        $this->get(route('management.users.index', $request))->assertSeeInOrder(
            [$user4->name, $user1->name, $user3->name, $user2->name]
        );
    }

    /** @test */
    public function manager_can_filter_users_by_name()
    {
        $mojtaba = User::factory()->create(['name' => 'mojtaba']);
        $other_user = User::factory()->create(['name' => 'Behnam']);

        $this->signIn(User::MANAGER);

        $request = [ 'name' => 'mojtaba' ];

        $this->get(route('management.users.index', $request))
            ->assertSee($mojtaba->name)
            ->assertDontSee($other_user->name);
    }


}
