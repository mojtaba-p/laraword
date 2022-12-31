<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageTagsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_tag_create_page()
    {
        $this->signIn(User::MANAGER);
        $this->get(route('management.tags.create'))->assertOk();
    }

    /** @test */
    public function user_can_create_a_tag()
    {
        $this->signIn(User::MANAGER);
        $tag = ['name' => 'some tag'];

        $this->post(route('management.tags.store', $tag))->assertRedirect(route('management.tags.index'));

        $this->assertDatabaseHas('tags', $tag);
    }

    /** @test */
    public function user_can_see_tags_list()
    {
        $this->signIn(User::MANAGER);
        $tag = Tag::factory()->create();
        $this->get(route('management.tags.index'))->assertSee($tag->name);

    }

    /** @test */
    public function user_can_see_tag_edit_page()
    {
        $this->signIn(User::MANAGER);
        $tag = Tag::factory()->create();

        $this->get(route('management.tags.edit', $tag))->assertSee($tag->name);

    }

    /** @test */
    public function user_can_update_tag()
    {
        $this->signIn(User::MANAGER);
        $tag = Tag::factory()->create();

        $this->put(route('management.tags.update', $tag), ['name' => 'tag changed'])
                ->assertRedirect(route('management.tags.index'));

        $this->assertDatabaseHas('tags', ['name' => 'tag changed']);
    }

    /** @test */
    public function user_can_destroy_tag()
    {
        $this->signIn(User::MANAGER);
        $tag = Tag::factory()->create();

        $this->delete(route('management.tags.destroy', $tag))->assertStatus(204);
        $this->assertDatabaseMissing('tags', ['name' => $tag->name]);
    }

     /** @test */
    public function published_articles_seen_in_tag_show_page()
    {
        $tag = Tag::factory()->has(Article::factory(['status' => 0]))->create();
        $draft = $tag->articles->first();

        $this->get(route('tags.show', $tag))
            ->assertStatus(200)
            ->assertDontSee([$draft->title, $draft->slug]);

        $tag = Tag::factory()->has(Article::factory(['status' => 1]))->create();
        $published = $tag->articles->first();

        $this->get(route('tags.show', $tag))
            ->assertStatus(200)
            ->assertSee([$published->title, $published->slug]);
    }
}
