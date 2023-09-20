<?php

namespace App\Notifications;

use App\Notifications\Notification\WhatsappNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvoiceStoreNotification extends Notification
{
    use Queueable;
    protected object $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WhatsappNotification::class, 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toWhatsapp(object $notifiable): string
    {
        return
            "Pelanggan INTERNET MURAH atas nama ". $this->invoice->members->name . PHP_EOL .
            "kami informasikan tagihan ". $this->invoice->desc ." sebesar Rp.". number_format($this->invoice->amount) .
            ". Dengan rincian sebagai berikut :". PHP_EOL .
            "Tagihan : Rp. ". number_format($this->invoice->price) . PHP_EOL .
            "Diskon : Rp. ". number_format($this->invoice->discount) . PHP_EOL .
            "Biaya Admin : Rp. ". number_format($this->invoice->fees) . PHP_EOL .
            "Jumlah : Rp. ". number_format($this->invoice->amount) . PHP_EOL . PHP_EOL .
            "silahkan melakukan pembayaran sebelum tanggal ". Carbon::parse($this->invoice->due)->translatedFormat('d F Y') .
            " untuk menghindari internet terisolir.". PHP_EOL .
            "pembayaran bisa melalui transfer ke ". PHP_EOL .
            "BCA.2470264295 an. MUHAMMAD ARIF MUNTAHA". PHP_EOL .
            "DANA.082229366506 an. MUHAMMAD ARIF MUNTAHA.". PHP_EOL.
            "terimakasih dan harap maklum";
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->invoice->members->name,
            'content' => 'Tagihan Baru' . $this->invoice->desc . ', Sebesar Rp.'. number_format($this->invoice->amount),
        ];
    }
}
