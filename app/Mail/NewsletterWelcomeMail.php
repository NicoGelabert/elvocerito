<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $confirmUrl;
    public string $unsubscribeUrl;

    public function __construct(public $subscriber)
    {
        $this->confirmUrl = route('newsletter.confirm', $this->subscriber->token);
        $this->unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->unsubscribe_token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmá tu suscripción',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newsletter.welcome',
            with: [
                'confirmUrl' => $this->confirmUrl,
                'unsubscribeUrl' => $this->unsubscribeUrl,
            ],
        );
    }
}