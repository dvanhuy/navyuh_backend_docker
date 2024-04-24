<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class EmailVerification extends Notification
{
    use Queueable;
    private $iduser;
    private $email_verification_token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($iduser,$email_verification_token)
    {
        $this->iduser = $iduser;
        $this->email_verification_token = $email_verification_token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Xác thực tài khoản')
            ->greeting('Xin chào ')
            ->line('Vui lòng nhấp vào liên kết bên dưới để xác thực tài khoản của bạn:')
            ->action('Xác thực', Config::get('app.frontend').'/register/verify?id='.$this->iduser.'&token='.$this->email_verification_token)
            ->line('Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
