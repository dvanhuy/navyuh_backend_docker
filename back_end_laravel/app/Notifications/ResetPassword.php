<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\HtmlString;

class ResetPassword extends Notification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
    
    public function toMail()
    {
        return (new MailMessage)
            ->subject('Yêu cầu đặt lại mật khẩu')
            ->line('Bạn nhận được email này vì một yêu cầu đặt lại mật khẩu đã được gửi tới tài khoản của bạn.')
            ->line('Đây là mà OTP của bạn')
            ->line(new HtmlString('<strong><span style="font-size: 40px;letter-spacing: 4px;color:black;">'.$this->token.'</span></strong>'))
            ->line('Nếu bạn không thực hiện yêu cầu này, bạn có thể bỏ qua email này.')
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
