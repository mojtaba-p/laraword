<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_others_profile()
    {
        $user = User::factory()->has(Article::factory(5))->create();

        $this->get(route('users.profile', $user))
            ->assertSee($user->articles->pluck('title')->toArray())
            ->assertStatus(200);

    }


    /** @test */
    public function user_can_see_users_list_in_index_page()
    {
        $this->withoutExceptionHandling();

        $this->signIn(User::MANAGER);

        $usernames = User::factory(5)->create()->pluck('username')->toArray();
        $this->get(route('management.users.index'))->assertSee($usernames);
    }

    /** @test */
    public function user_can_update_user_roles()
    {
        $user = User::factory()->create();

        $this->signIn(User::MANAGER);

        $request = [
            'username' => $user->username,
            'role' => User::MANAGER
        ];

        $this->post(route('management.users.update.role'), $request);

        $this->assertEquals(User::MANAGER, User::find($user->id)->role);
    }


    /** @test */
    public function only_admin_can_update_admin_role()
    {
        $user = User::factory()->create(['role' => User::ADMIN]);
        $this->signIn(User::MANAGER);
        $request = [
            'username' => $user->username,
            'role' => User::USER
        ];

        Config::set('laraword.admins', [$user->email]);

        $this->post(route('management.users.update.role'), $request)
        ->assertSessionHasErrors(['cant_update_admin']);

        $this->signIn(User::ADMIN);

        Config::set('laraword.admins', [auth()->user()->email]);

        $this->post(route('management.users.update.role'), $request);
        $this->assertEquals(User::USER, User::find($user->id)->role);
    }

    /** @test */
    public function only_admin_and_manager_can_manage_users()
    {
        $this->signIn();
        $this->get(route('management.users.index'))->assertStatus(403);

        $this->signIn(User::MANAGER);
        $this->get(route('management.users.index'))->assertStatus(200);
    }

    /** @test */
    public function only_admin_and_manager_can_update_user_role()
    {
        $user = User::factory()->create();

        $this->signIn();

        $request = [
            'username' => $user->username,
            'role' => User::MANAGER
        ];

        $this->post(route('management.users.update.role'), $request)->assertStatus(403);
    }


}
