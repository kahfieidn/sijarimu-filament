<?php

namespace App\Notifications;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PermohonanDone extends Notification
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
            ->subject('Permohonan #' . $shortenedUuid . ' Selesai di Proses!')
            ->line('Permohonan anda telah selesai di proses.')
            ->line('Sekarang anda dapat memantau proses berkas anda pada menu "Tracking" di Aplikasi Sijarimu:')
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
        $fileUrl = url('storage/' . $this->permohonan->izin_terbit);

        return (new WhacenterService())
            ->to('62' . $this->permohonan->user->nomor_hp)
            ->file('')
            ->line('*Yang terhormat, ' . $this->permohonan->user->name . "*\n\n" .
                "📄 Permohonan dengan ID # *" . $this->permohonan->id . "* perihal kepengurusan *" . $this->permohonan->perizinan->nama_perizinan . "*.\n\n" .
                "Dapat kami informasikan Permohonan anda telah selesai di proses.\n\n" .
                "Anda bisa mengunduh berkas izin terbit melalui Aplikasi Sijarimu, Silahkan login menggunakan akun anda dan unduh izin pada permohonan anda.\n\n" .
                "Terima kasih.\n" .
                "📲 *Sijarimu* - Aplikasi Perizinan Non OSS Online : https://s.id/sijarimu");
    }
}
