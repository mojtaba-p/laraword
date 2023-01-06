<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArticleThumbnailSeederJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Article $article;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(app()->environment('production')) return;
        if($this->article->thumbnail != null) return;
        if(!$resource = $this->createThumbnailResource()) return;

        $file = new UploadedFile(stream_get_meta_data($resource)['uri'],
            $this->article->slug . '.webp', 'webp');
        $this->article->syncThumbnail($file);
    }

    /*
    * fetch picture and create temp file.
    */
    private function createThumbnailResource()
    {
        ini_set('user_agent', 'Mozilla/5.0 Firefox/108.0');
        $tries = 0;
        $resource = null;
        do{
            $tries++;
            try{
                $thumbnail = file_get_contents(
                    'https://picsum.photos/id/'
                    . mt_rand(1, 500) . '/' . mt_rand(300, 600) . '/' . mt_rand(300, 600) . '.webp'
                );

                $resource = tmpfile();
                fwrite($resource, $thumbnail);
            } catch (\Exception $e){
                if(strpos( $e->getMessage(),404)) continue;
                dump('fail: '.$e->getMessage());
                break;
            }
        }while($tries < 5);
        return $resource;
    }
}
