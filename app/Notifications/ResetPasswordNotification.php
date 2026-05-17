<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Token reset password
     */
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Saluran notifikasi yang digunakan
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Bangun pesan email
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('🔐 Reset Password Akun SIMelek Anda')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mereset password akun SIMelek Anda.')
            ->line('Klik tombol di bawah ini untuk membuat password baru. Link ini hanya berlaku selama **60 menit**.')
            ->action('Reset Password Sekarang', $resetUrl)
            ->line('Jika Anda tidak merasa meminta reset password, abaikan email ini. Password Anda tidak akan berubah.')
            ->line('---')
            ->line('**Catatan Keamanan:** Jangan bagikan link ini kepada siapapun.')
            ->salutation('Salam, Tim SIMelek – Teknik Elektro');
    }
}
