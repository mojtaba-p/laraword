<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_for_article()
    {
        $article = Article::factory()->create();
        $search_str = substr($article->title,0, (strlen($article->title)) / 2);
        $this->get('/search?q='.$search_str)->assertSee($article->title);
    }

    /** @test */
    public function user_can_search_for_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->get('/search/people?q='.$user->name)->assertSee($user->name);
    }


}
