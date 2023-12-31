<?php

namespace App\Notifications\Notification;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class WhatsappNotification
{
    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toWhatsapp($notifiable);

        $to = $notifiable->routeNotificationFor('Whatsapp');

        Http::asForm()->post(config('whatsapp.host'). '/message/text?key='.config('whatsapp.instance'), [
            'id' => '62'.$to,
            'message' => $message
        ]);
    }
}
