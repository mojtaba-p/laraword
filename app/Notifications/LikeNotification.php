<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LikeNotification extends ActivityNotification
{
    use Queueable;

    public function __construct(Model $object, User $acted_by)
    {
        parent::__construct($object, $acted_by);
        $this->activity = __('liked');
    }
}
