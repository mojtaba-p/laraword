<?php

namespace App\Providers;

use App\Contracts\Likable;
use App\Models\Article;
use App\Models\Like;
use App\Observers\LikeObserver;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LikeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        Like::observe(LikeObserver::class);
    }
}
