<?php

namespace Database\Seeders;

use App\Jobs\ArticleThumbnailSeederJob;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
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
            $user->articles()->each(function ($article) {
                ArticleThumbnailSeederJob::dispatch($article)->onQueue('thumbnails');
            });
        });

        Artisan::call('queue:work --queue=thumbnails --stop-when-empty');
    }
}
