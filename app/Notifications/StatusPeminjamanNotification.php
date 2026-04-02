<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Events\NewNotification;

class StatusPeminjamanNotification extends Notification
{
    use Queueable;

    public $judul;
    public $pesan;
    public $link;

    public function __construct($judul, $pesan, $link = '#')
    {
        $this->judul = $judul;
        $this->pesan = $pesan;
        $this->link = $link;
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan di database
    }

    public function toDatabase($notifiable)
    {
        $data = [
            'user_id' => $notifiable->id,
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'message' => $this->judul . ' - ' . $this->pesan,
            'link' => $this->link,
        ];

        // Broadcast realtime
        event(new NewNotification($data));

        return $data;
    }
}
