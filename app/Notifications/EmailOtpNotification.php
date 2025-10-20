<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $code,
        public readonly int $ttlMinutes = 10
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi Email Anda')
            ->greeting('Halo ' . ($notifiable->name ?? 'Pengguna'))
            ->line('Gunakan kode OTP berikut untuk memverifikasi email Anda:')
            ->line("<span style=\"font-size:28px;font-weight:bold;letter-spacing:6px;\">{$this->code}</span>")
            ->line("Kode ini berlaku selama {$this->ttlMinutes} menit.")
            ->line('Jika Anda tidak meminta kode ini, abaikan email ini.')
            ->salutation(config('app.name'))
            ->markdown('mail.otp', [
                'code' => $this->code,
                'ttl' => $this->ttlMinutes,
                'app' => config('app.name'),
            ]);
    }
}
