<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserSettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_settings_page()
    {
        $this->signIn();

        $this->get(route('dashboard.profiles'))
            ->assertStatus(200)
            ->assertSee([auth()->user()->name]);
    }

    /** @test */
    public function user_can_change_settings()
    {
        $this->signIn();

        $settings = [
            'name' => auth()->user()->name,
            'bio' => 'lorem ipsum',
            'social' => ['twitter' => 'johnDoe', 'github' => 'ajohnDoe', 'facebook' => 'johnDoeIsHere']
        ];

        $this->post(route('dashboard.profiles.store'), $settings)
            ->assertRedirect(route('dashboard.profiles'));

        $settings['social'] = json_encode($settings['social']); // just for assertion
        $this->assertDatabaseHas('users', $settings);

    }

    /** @test */
    public function user_can_have_profile_photo()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $settings = [
            'name' => auth()->user()->name,
            'bio' => 'lorem ipsum',
            'social' => ['twitter' => 'johnDoe', 'github' => 'ajohnDoe', 'facebook' => 'johnDoeIsHere'],
            'photo' => UploadedFile::fake()->image('random.jpg')
        ];

        $this->post(route('dashboard.profiles.store'), $settings);

        $this->assertNotNull(auth()->user()->photo);
        $this->assertFileExists(public_path(auth()->user()->getPhotoPath()));
    }

    /** @test */
    public function user_can_change_profile_photo()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $settings = [
            'name' => auth()->user()->name,
            'bio' => 'lorem ipsum',
            'social' => ['twitter' => 'johnDoe', 'github' => 'ajohnDoe', 'facebook' => 'johnDoeIsHere'],
            'photo' => UploadedFile::fake()->image('random.jpg')
        ];

        $this->post(route('dashboard.profiles.store'), $settings);
        $first_photo = auth()->user()->photo;

        $this->assertNotNull($first_photo);
        $settings = [
            'name' => auth()->user()->name,
            'bio' => 'lorem ipsum',
            'social' => ['twitter' => 'johnDoe', 'github' => 'ajohnDoe', 'facebook' => 'johnDoeIsHere'],
            'photo' => UploadedFile::fake()->image('random.jpg')
        ];

        $this->post(route('dashboard.profiles.store'), $settings);

        $this->assertNotTrue(auth()->user()->photo == $first_photo);
        $this->assertFileDoesNotExist( public_path('profiles/'.$first_photo) );
        $this->assertFileExists(public_path(auth()->user()->getPhotoPath()));
    }


}
