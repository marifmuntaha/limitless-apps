<?php

namespace App\Notifications;

use App\Notifications\Notification\WhatsappNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentCreate extends Notification
{
    use Queueable;

    protected object $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
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
    public function toWhatsapp(object $notifiable)
    {
        return "Pelanggan INTERNET MURAH atas nama ". $this->payment->invoices->members->name . PHP_EOL .
            "terimakasih telah melakukan pembayaran tagihan ". $this->payment->invoices->desc ." sebesar Rp.".
            number_format($this->payment->amount) ." pada tanggal ". Carbon::parse($this->payment->at)->translatedFormat('d F Y');
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
