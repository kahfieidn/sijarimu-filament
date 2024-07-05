<?php

namespace App\Notifications;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PermohonanRejected extends Notification
{
    use Queueable;
    private Permohonan $permohonan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $shortenedUuid = substr($this->permohonan->id, 0, 6);

        return (new MailMessage)
            ->greeting('Yang terhormat,' . ' ' . $this->permohonan->user->name)
            ->subject('Permohonan #' . $shortenedUuid . ' ' . 'Ditolak!')
            ->line('Mohon maaf, Permohonan anda ditolak dan perlu diperbaiki.')
            ->line('Alasan verifikator :')
            ->line(new HtmlString("" . $this->permohonan->message . ""))
            ->line('Silahkan diperbaiki sesuai dengan instruksi tersebut, lalu dapat mengajukan ulang.')
            ->action('Login Aplikasi Sijarimu', url('https://sijarimu.kepri.pro'))
            ->line('Terimakasih telah menggunakan aplikasi Sijarimu!');
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
