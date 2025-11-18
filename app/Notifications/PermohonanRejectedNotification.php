<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Permohonan;

class PermohonanRejectedNotification extends Notification
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
            ->subject('Pemberitahuan Hasil Seleksi Permohonan Magang')
            ->greeting('Halo ' . $this->permohonan->nama)
            ->line('Terima kasih atas ketertarikan Anda untuk melaksanakan kegiatan magang di instansi kami.')
            ->line('Berdasarkan hasil peninjauan administrasi dan ketersediaan kuota, kami memohon maaf karena **belum dapat menerima** permohonan magang Anda pada periode ini.')
            ->line('Silakan unduh surat balasan resmi melalui tombol di bawah ini atau melalui dashboard sistem.')
            ->action('Lihat Surat Balasan', url('/dashboard')) 
            ->line('Kami mendoakan kesuksesan untuk studi dan karir Anda ke depannya.');
    }
}
