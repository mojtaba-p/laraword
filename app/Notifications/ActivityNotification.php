<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityNotification extends Notification
{
    use Queueable;


    protected $object;
    protected $object_class;
    protected $acted_by;
    protected $activity;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Model $object, User $acted_by)
    {
        $this->object = $object;
        $this->acted_by = $acted_by;
        $this->object_class = get_class($object);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if($this->object_class == 'App\Models\Article'){
            $subject = 'article';
            $content = $this->object->title;
            $article_slug = $this->object->slug;
            cache()->forget($this->object->author->notificationsCacheKey());

        }

        if($this->object_class == 'App\Models\ArticleComment'){
            $subject = 'comment';
            $content = $this->object->body;
            $article_slug = $this->object->article->slug;
            cache()->forget($this->object->writer->notificationsCacheKey());

        }

        return [
            'message' => $this->acted_by->name .' '. $this->activity. ' '.__('your').' '.$subject,
            'content' => $content,
            'url'     => url()->route('articles.show', $article_slug),
        ];
    }
}
