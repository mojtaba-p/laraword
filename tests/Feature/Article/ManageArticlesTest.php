<?php

namespace Article;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ManageArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function gust_cannot_manage_articles()
    {
        $article = Article::factory()->raw();
        $this->post('dashboard/articles', $article)->assertRedirect('/login');
    }

    /** @test */
    public function article_list_shows_articles()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $article = Article::factory()->create();

        $response = $this->get('/dashboard/articles')
            ->assertSee($article->title);
    }

    /** @test */
    public function article_content_must_sanitize()
    {
        $this->signIn();
        $article = [
            'title' => 'Some Articles Title',
        ];
        $article['content'] = '<?php die("danger"); ?>';
        $article['content'] .= '<a href="http://google.com"> google.com </a>';
        $article['content'] .= '<p> hello world  </p>';
        $article['content'] .= '<script>alert("warning");</script>';

        tap($article, function ($article) {
            $this->post('dashboard/articles', $article)->assertRedirect('/dashboard/articles');
        });
        $expected = [
            'title' => 'Some Articles Title',
        ];
        $expected['content'] = '&lt;?php die("danger"); ?&gt;';
        $expected['content'] .= '<a href="http://google.com" rel="nofollow noreferrer noopener" target="_blank"> google.com </a>';
        $expected['content'] .= '<p> hello world  </p>';
        $expected['content'] .= '';
        $this->assertDatabaseHas('articles', $expected);
    }

    /** @test */
    public function all_users_can_see_article_show_page()
    {
        $article = Article::factory()->create(['category_id' => Category::factory()->create()->id, 'status' => 1]);

        $this->get(route('articles.show', $article))
            ->assertSee([$article->title, strtoupper($article->category->name), $article->content]);
    }

    /** @test */
    public function article_views_increase_on_user_see()
    {
        $article = Article::factory()->create(['status' => 1]);
        $this->get(route('articles.show', $article));
        $this->assertEquals(1, Article::find($article->id)->views_count);
    }


    /** @test */
    public function users_cant_see_draft_articles()
    {
        $article = Article::factory()->create(['status' => 0]);
        $this->get(route('articles.show', $article))
            ->assertStatus(404);
    }

    /** @test */
    public function user_can_mark_article_as_pinned()
    {
        $this->signIn();
        $article = Article::factory()->create();
        $this->post(route('dashboard.articles.pin', $article))->assertSessionHas('success_status');

    }

    /** @test */
    public function article_have_related_articles_by_tags()
    {
        $articles = Article::factory(5)->create();
        $tags = Tag::parseTagString('tag1,tag2,tag3,tag4,tag5');

        $articles->first()->tags()->sync([1,2,3,5]);

        Article::find(2)->tags()->sync([1,2,4]); // second
        Article::find(3)->tags()->sync([4,5]); // third
        Article::find(4)->tags()->sync([1,3,4,5]); // first
        Article::find(5)->tags()->sync([4]); // not in the list

        $related_articles = $articles->first()->relatedArticles()->pluck('id')->toArray();
        $this->assertEquals($related_articles, [4,2,3]);
    }

    /** @test */
    public function user_can_see_all_articles_in_management_panel()
    {
        $this->withoutExceptionHandling();
        $this->signIn(User::MANAGER);
        User::factory(5)->has(Article::factory())->create();
        $this->get(route('management.articles.index'))->assertSee(Article::get()->pluck('title')->toArray());
    }

    /** @test */
    public function users_without_role_cant_see_all_articles()
    {
        $this->signIn();
        User::factory(5)->has(Article::factory())->create();

        $this->get(route('management.articles.index'))->assertStatus(403);

    }


}
