<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class ArticleThumbnailSeeder extends Seeder implements ShouldQueue
{
    use Queueable;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            auth()->login($user);
            $user->articles()->each(function ($article) {
                if($article->thumbnail != null) return;
                if(!$resource = $this->createThumbnailResource()) return;
                $file = new UploadedFile(stream_get_meta_data($resource)['uri'],
                    $article->slug . '.webp', 'webp');
                $article->syncThumbnail($file);
            });
        });
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
                dump('fail');
                break;
            }
        }while($tries < 5);
        return $resource;
    }
}
