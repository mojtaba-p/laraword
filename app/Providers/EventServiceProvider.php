<?php

namespace App\Providers;

use App\Events\ArticleSeen;
use App\Events\Commented;
use App\Events\Liked;
use App\Listeners\SendCommentNotification;
use App\Listeners\SendLikeNotification;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \App\Events\Liked::class => [\App\Listeners\SendLikeNotification::class],
        \App\Events\Commented::class => [\App\Listeners\SendCommentNotification::class],

    ];


    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
