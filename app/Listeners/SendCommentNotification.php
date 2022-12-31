<?php

namespace App\Listeners;

use App\Events\Commented;
use App\Models\Article;
use App\Notifications\CommentNotification;
use App\Notifications\LikeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCommentNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\Commented  $event
     * @return void
     */
    public function handle(Commented $event)
    {
        $notifiable = ($event->model instanceof Article) ? 'author' : 'writer';
        Notification::send($event->model->$notifiable, new CommentNotification($event->model, $event->user));
    }
}
