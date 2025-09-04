<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Permohonan;

class PermohonanAcceptedNotification extends Notification
{
    use Queueable;

    protected $permohonan;

    public function __construct(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permohonan Magang Anda Diterima')
            ->greeting('Halo ' . $this->permohonan->nama)
            ->line('Selamat, permohonan magang Anda telah diterima.')
            ->action('Lihat Surat Balasan', url('/user/tracking/' . $this->permohonan->id))
            ->line('Silakan unduh surat balasan resmi dari sistem.');
    }
}
