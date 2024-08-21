<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class WhacenterChannel
{
    public function send($notifiable, Notification $notification)
    {
        // Memanggil metode toWhacenter dari notifikasi
        $message = $notification->toWhacenter($notifiable);
        $message->send();
    }
}
