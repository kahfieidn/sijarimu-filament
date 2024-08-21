<?php

namespace App\Notifications;

use App\Models\Permohonan;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
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
        return ['mail', WhacenterChannel::class];
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
            ->action('Login Aplikasi Sijarimu', url('https://sijarimu-v2.kepri.pro'))
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

    public function toWhacenter($notifiable)
    {
        $plainMessage = strip_tags($this->permohonan->message);
        $decodedMessage = html_entity_decode($plainMessage, ENT_QUOTES, 'UTF-8');
    
        return (new WhacenterService())
            ->to('62' . $this->permohonan->user->nomor_hp)
            ->file('')
            ->line('*Yang terhormat, ' . $this->permohonan->user->name . "*\n\n" .
                "📄 Permohonan dengan ID # *" . $this->permohonan->id . "* perihal kepengurusan *" . $this->permohonan->perizinan->nama_perizinan . "*.\n\n" .
                "Mohon maaf, Permohonan anda ditolak dan perlu diperbaiki.\n\n" .
                "Alasan verifikator: " . $decodedMessage . "\n\n" .
                "Silahkan diperbaiki sesuai dengan instruksi tersebut, lalu dapat mengajukan ulang.\n\n" .
                "Terima kasih.\n" .
                "📲 *Sijarimu* - Aplikasi Perizinan Non OSS Online : https://s.id/sijarimu");
    }
}
