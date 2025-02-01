<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event)
    {
        $order=$event->order;
        $user=User::where('store_id',$order->store_id)->first();
        $admin = Admin::where('email','=',Auth::user()->email)->first();
       
       if ($user) {
        $user->notify(new OrderCreatedNotification($order));
       }
       elseif($admin){
        $admin->notify(new OrderCreatedNotification($order));

       }

        //if use collection of users :
        // $users=User::where('store_id',$order->storeId)->get();
        // Notification::send($users,new OrderCreatedNotification($order));
    }
}
