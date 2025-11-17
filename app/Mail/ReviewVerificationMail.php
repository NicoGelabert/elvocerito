<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $review;

    /**
     * Crear una nueva instancia del mailable
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Construir el mensaje
     */
    public function build()
    {
        $verificationUrl = url("/reviews/verify/{$this->review->token}");

        return $this->subject('Verifica tu review')
                    ->markdown('emails.review_verification')
                    ->with([
                        'name' => $this->review->name,
                        'verificationUrl' => $verificationUrl,
                    ]);
    }
}
