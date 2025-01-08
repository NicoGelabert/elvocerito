<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends ResetPassword
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false));

        return (new MailMessage)
            ->subject(Lang::get('emails.reset_password.subject'))
            ->greeting(Lang::get('emails.reset_password.greeting'))
            ->line(Lang::get('emails.reset_password.line_1'))
            ->action(Lang::get('emails.reset_password.cta'), $url)
            ->line(Lang::get('emails.reset_password.line_2'))
            ->line(Lang::get('emails.reset_password.line_3'))
            ->salutation(Lang::get('emails.reset_password.salutation'));            
    }
}
