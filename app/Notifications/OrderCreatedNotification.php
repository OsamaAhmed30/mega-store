<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $order;
    public $addr;

    public function __construct($order)
    {
        $this->order = $order;
        $this->addr = $this->order->billingAddress;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array  //$notifiable is the user who recieve notifications or any model that extend notifications
    {
        //return ['database','broadcast'];
        return ['mail', 'database','broadcast'];
        $channels = ['database'];
        if ($notifiable->notification_prefrences['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_prefrences['order_created']['database'] ?? false) {
            $channels[] = 'database';
        }
        if ($notifiable->notification_prefrences['order_created']['mail'] ?? false) {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
       
        return (new MailMessage)
            ->subject("New Order Created #{$this->order->number}")
            ->greeting("Hi {$notifiable->name}")
            ->line("Congrats your New Order Created #{$this->order->number} Succeffully by {$this->addr->name} from {$this->addr->country_name}")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }
    public function toBroadcast(object $notifiable)
    {
        return new BroadcastMessage([
            'body' => "New Order Created #{$this->order->number} by {$notifiable->name}",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,

        ]);
          
    }
    public function toDatabase(object $notifiable)
    {
        return [
            'body' => "New Order Created #{$this->order->number} by {$notifiable->name}",
            'icon' => 'fas fa-file',
            'url' => url('/admin/dashboard'),
            'order_id' => $this->order->id,

        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
