<?php

namespace Tests\Feature;

use App\Models\Bookmark;
use App\Models\Box;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoxTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_boxes()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $box = ['name' => 'some list'];
        $this->post(route('dashboard.boxes.store'), $box)->assertStatus(200);
        $this->assertDatabaseHas('boxes', $box);
    }

    public function test_user_can_create_private_boxes()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $box = ['name' => 'some list', 'private' => true];
        $this->post(route('dashboard.boxes.store'), $box)->assertStatus(200);
        $this->assertDatabaseHas('boxes', $box);
    }

    public function test_user_can_update_a_box()
    {
        $this->signIn();
        $box = Box::factory()->create(['user_id' => auth()->id()]);
        $request = ['name' => 'some list', 'private' => true];
        $this->put(route('dashboard.boxes.update', $box), $request)
            ->assertStatus(200);
        $this->assertDatabaseHas('boxes', array_merge($box->getAttributes(), $request));
    }

    public function test_user_can_destroy_a_box()
    {
        $this->signIn();
        $box = Box::factory()->create(['user_id' => auth()->id()]);
        $this->delete(route('dashboard.boxes.destroy', $box))->assertStatus(204);
        $this->assertDatabaseMissing('boxes', ['slug' => $box->slug, 'user_id' => auth()->id()]);
    }

    public function test_boxes_can_be_seen_in_user_profile_page()
    {
        $user = User::factory()->create();
        $bookmark = Bookmark::factory()->create(['user_id' => $user->id]);

        $box = Box::factory(2)->create();
        $request = [
            'boxes' => [$box[0]->slug, $box[1]->slug],
            'bookmark' => $bookmark->id
        ];

        $this->get(route('users.boxes', $user))->assertStatus(200);

    }


}
