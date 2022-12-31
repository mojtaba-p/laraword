<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_managers_can_create_new_collection()
    {
        $this->signIn(User::MANAGER);
        $this->get(route('management.collections.create'))->assertStatus(200);
    }

    /** @test */
    public function user_can_create_new_collection()
    {
        $this->signIn(User::MANAGER);

        $article = Article::factory()->create(['status' => 1]);
        $request = [ 'name' => 'some collection', 'articles' => [$article->slug] ];

      $this->post(route('management.collections.store'), $request)
            ->assertRedirect(route('management.collections.index'));

        $this->assertEquals(1, Collection::first()->articles->count());
    }

    /** @test */
    public function user_can_see_collection_edit_page()
    {
        $this->signIn(User::MANAGER);

        $article = Article::factory()->create(['status' => 1]);
        $collection = Collection::factory()->create();

        $collection->articles()->sync($article);

        $this->get(route('management.collections.edit', $collection))
            ->assertStatus(200)
            ->assertSee([$collection->name, $article->name, $article->slug]);

    }

    /** @test */
    public function user_can_update_collection()
    {
        $this->signIn(User::MANAGER);

        $article = Article::factory()->create(['status' => 1]);
        $collection = Collection::factory()->create();
        $collection->articles()->sync($article);
        $article_2 = Article::factory()->create(['status' => 1]);

        $request = [
            'name' => 'new name is this',
            'articles' => [$article->slug, $article_2->slug]
        ];

        $this->put(route('management.collections.update', $collection), $request)
            ->assertRedirect(route('management.collections.index'));

        $this->assertEquals(2, Collection::first()->articles->count());

    }

    /** @test */
    public function user_can_delete_collection()
    {
        $this->signIn(User::MANAGER);

        $article = Article::factory()->create(['status' => 1]);
        $collection = Collection::factory()->create();
        $collection->articles()->sync($article);

        $this->delete(route('management.collections.destroy',  $collection))
            ->assertSessionHasAll(['success_status'])
            ->assertRedirect(route('management.collections.index'));
    }

    /** @test */
    public function only_managers_can_see_collection_create_page()
    {
        $this->signIn();
        $this->get(route('management.collections.create'))->assertStatus(403);
        $this->signIn(User::MANAGER);
        $this->get(route('management.collections.create'))->assertStatus(200);

    }


    /** @test */
    public function only_managers_can_create_collection()
    {
        // manager means user role must be admin or manager
        $this->signIn();
        $article = Article::factory()->create(['status' => 1]);
        $request = [ 'name' => 'some collection', 'articles' => [$article->slug] ];

        $this->post(route('management.collections.store'), $request)->assertStatus(403);
        $this->assertEquals(0, Collection::count());
    }

    /** @test */
    public function normal_user_cant_see_collections_management_index_page()
    {
        $this->signIn();
        $this->get(route('management.collections.index'))->assertStatus(403);

        $this->signIn(User::EDITOR);
        $this->get(route('management.collections.index'))->assertStatus(200);

    }

    /** @test */
    public function normal_user_cant_add_article_to_collection()
    {
        $article = Article::factory()->create();
        $collection = Collection::factory()->create();
        $request = [
            'article' => $article->slug,
            'collection' => $collection->slug
        ];

        $this->signIn();
        $this->post(route('management.collections.add'), $request)->assertStatus(403);

        $this->signIn(User::EDITOR);
        $this->post(route('management.collections.add'), $request)->assertStatus(302);
    }

    /** @test */
    public function users_can_see_collection_articles_in_collection_show_page()
    {
        $this->withoutExceptionHandling();
        $collection = Collection::factory()->create();
        $articles = Article::factory(5)->create(['status' => 1]);
        $collection->articles()->sync($articles);

        $this->get(route('collections.show', $collection))
            ->assertSee($articles->pluck('id')->toArray());

    }


}
