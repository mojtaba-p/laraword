<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_category_create_page()
    {
        $this->signIn(User::MANAGER);
        $this->get(route('management.categories.create'))->assertOk();
    }

    /** @test */
    public function user_can_create_a_category()
    {
        $this->signIn(User::MANAGER);
        $category = ['name' => 'some category'];

        $this->post(route('management.categories.store', $category))->assertRedirect(route('management.categories.index'));

        $this->assertDatabaseHas('categories', $category);
    }

    /** @test */
    public function user_can_see_categories_list()
    {
        $this->signIn(User::MANAGER);
        $category = Category::factory()->create();
        $this->get(route('management.categories.index'))->assertSee($category->name);

    }

    /** @test */
    public function user_can_see_category_edit_page()
    {
        $this->signIn(User::MANAGER);
        $category = Category::factory()->create();

        $this->get(route('management.categories.edit', $category))->assertSee($category->name);

    }

    /** @test */
    public function user_can_update_category()
    {
        $this->signIn(User::MANAGER);
        $category = Category::factory()->create();

        $this->put(route('management.categories.update', $category), ['name' => 'category changed'])
            ->assertRedirect(route('management.categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'category changed']);
    }

    /** @test */
    public function user_can_destroy_category()
    {
        $this->signIn(User::MANAGER);
        $category = Category::factory()->create();

        $this->delete(route('management.categories.destroy', $category))->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['name' => $category->name]);
    }

    /** @test */
    public function published_articles_seen_in_category_show_page()
    {
        $category = Category::factory()->has(Article::factory(['status' => 0]))->create();
        $draft = $category->articles->first();

        $this->get(route('categories.show', $category))
            ->assertStatus(200)
            ->assertDontSee([$draft->title, $draft->slug]);

        $category = Category::factory()->has(Article::factory(['status' => 1]))->create();
        $published = $category->articles->first();

        $this->get(route('categories.show', $category))
            ->assertStatus(200)
            ->assertSee([$published->title, $published->slug]);
    }

}
