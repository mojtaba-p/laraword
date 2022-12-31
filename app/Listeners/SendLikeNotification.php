<?php

namespace App\Listeners;

use App\Events\Liked;
use App\Models\Article;
use App\Models\User;
use App\Notifications\LikeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendLikeNotification
{

    /**
     * Handle the event.
     *
     * @param  \App\Events\Liked  $event
     * @return void
     */
    public function handle(Liked $event)
    {
        $notifiable = ($event->model instanceof Article) ? 'author' : 'writer';
        Notification::send($event->model->$notifiable, new LikeNotification($event->model, $event->user));
    }
}
