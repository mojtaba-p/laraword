<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Article;

class NotificationController extends Controller
{
    public function index(){
        if(!in_array('application/json', request()->getAcceptableContentTypes())){return to_route('dashboard'); }

        $user = auth()->user();
        return cache()->remember($user->notificationsCacheKey(), 60*60*24, function() use ($user){
            return NotificationResource::collection($user->unreadNotifications);
        });
    }

    public function markIt($notification)
    {
        $user_notification = auth()->user()->notifications->find($notification);
        $user_notification->markAsRead();
        cache()->forget(auth()->user()->notificationsCacheKey());
        return redirect($user_notification->data['url']);

    }
}
