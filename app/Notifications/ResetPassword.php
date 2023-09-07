<?php

namespace App\Notifications;

use App\Notifications\Notification\WhatsappNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;
    public string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WhatsappNotification::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toWhatsapp(object $notifiable): string
    {
        return "Silahkan mengikuti tautan berikut ini untuk mengatur ulang sandi anda: ". url('password/reset', $this->token);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
