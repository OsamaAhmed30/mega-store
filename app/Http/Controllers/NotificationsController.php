<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function markAsRead(Request $request){
        $notificationId = request('id');

        $userUnreadNotification = auth()->user()
                            ->unreadNotifications
                            ->where('id', $notificationId)
                            ->first();
        $userUnreadNotification->markAsRead();
        return redirect("$request->url?notification-id=$request->id");
    }
}
