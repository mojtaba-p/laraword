<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends ActivityNotification
{
    use Queueable;
    public function __construct(Model $object, User $acted_by)
    {
        parent::__construct($object, $acted_by);
        if(str_contains(get_class($object), 'ArticleComment')){
            $this->activity = __('replied to');
        } else {
            $this->activity = __('commented to');
        }
    }
}
