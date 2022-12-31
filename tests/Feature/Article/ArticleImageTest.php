<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_upload_article_thumbnail_on_create()
    {
        $this->signIn();

        $article = [
            'title' => 'Some Articles Title',
            'content' => 'some text for the this article must goes here.',
            'thumbnail' => UploadedFile::fake()->image('random-name.jpg'),
        ];

        $this->post('dashboard/articles', $article);
        unset($article['thumbnail']);
        $this->assertDatabaseHas('articles', $article);
        $this->assertFileExists(public_path(Article::first()->thumbnailPath()));
    }

    /** @test */
    public function article_thumbnail_must_be_a_image()
    {
        $this->signIn();

        $article = [
            'title' => 'Some Articles Title',
            'content' => 'some text for the this article must goes here.',
            'thumbnail' => UploadedFile::fake()->create('malicious', 1024, 'exe'),
        ];

        $this->post('dashboard/articles', $article)->assertSessionHasErrors(['thumbnail']);
    }

    /** @test */
    public function user_can_upload_photo_for_articles_content()
    {
        $this->signIn();
        $article = Article::factory()->create();

        $this->post(route('dashboard.users.images.store'),
            ['image' => UploadedFile::fake()->create('malicious', 1024, 'exe')],
            ['Accept' => 'application/json']
        )->assertJsonValidationErrorFor('image');

        $result = $this->post(route('dashboard.users.images.store'),
            ['image' => UploadedFile::fake()->image('random-name.jpg')],
            ['Accept' => 'application/json']
        )->content();

        $this->assertContains('url', array_keys(json_decode($result, true)));
    }
}
