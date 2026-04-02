<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PeminjamanDiterima extends Notification
{
    use Queueable;

    protected $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via($notifiable)
    {
        return ['database']; // hanya simpan di database
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Peminjaman alat {$this->peminjaman->alat->nama_alat} telah diterima.",
            'peminjaman_id' => $this->peminjaman->id
        ];
    }
}
