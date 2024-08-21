<?php

namespace App\Notifications;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PermohonanCreated extends Notification
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
            ->subject('Permohonan #' . $shortenedUuid . ' Berhasil di Ajukan!')
            ->line('Permohonan anda telah berhasil kami terima. Selanjutnya, tindaklanjut permohonan ini membutuhkan waktu 4 - 7 hari bursa kerja. Setelah berkas selesai diproses, anda akan menerima notifikasi dari kami apabila berkas telah selesai diproses.')
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
        return (new WhacenterService())
            ->to('62' . $this->permohonan->user->nomor_hp)
            ->file('')
            ->line('*Yang terhormat, ' . $this->permohonan->user->name . "*\n\n" .
                "📄 Anda telah membuat permohonan baru dengan ID *" . $this->permohonan->id . "* perihal kepengurusan *" . $this->permohonan->perizinan->nama_perizinan . "*.\n\n" .
                "Permohonan Anda telah berhasil kami terima. Selanjutnya, tindak lanjut permohonan ini membutuhkan waktu *4 - 7 hari* bursa kerja.\n\n" .
                "Setelah berkas selesai diproses, Anda akan menerima notifikasi dari kami. Sekarang Anda dapat memantau proses berkas Anda pada menu *\"Tracking\"* di Aplikasi Sijarimu.\n\n" .
                "Terima kasih.\n" .
                "📲 *Sijarimu* - Aplikasi Perizinan Non OSS Online : https://s.id/sijarimu");
    }
}
