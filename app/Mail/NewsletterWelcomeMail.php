<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $confirmUrl;
    public $unsubscribeUrl;

    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber; // ✅ pasar el modelo completo
    }

    public function build()
    {
        $this->confirmUrl = route('newsletter.confirm', $this->subscriber->token);
        $this->unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->unsubscribe_token);

        return $this->subject('Confirma tu suscripción')
            ->view('emails.newsletter.welcome')
            ->with([
                'confirmUrl' => $this->confirmUrl,
                'unsubscribeUrl' => $this->unsubscribeUrl,
            ]);
    }
}
