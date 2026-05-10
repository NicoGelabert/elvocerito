<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public $token;
    protected ?string $frontendUrl;

    public function __construct($token, ?string $frontendUrl = null)
    {
        $this->token = $token;
        $this->frontendUrl = $frontendUrl ?? config('app.admin_url');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->frontendUrl
            . '/reset-password/'
            . $this->token
            . '?email=' . urlencode($notifiable->getEmailForPasswordReset());

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
