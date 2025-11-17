<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function build()
    {
        return $this->subject('Nueva review verificada')
                    ->markdown('emails.new_review_notification')
                    ->with([
                        'productName' => $this->review->product->name,
                        'review' => $this->review,
                    ]);
    }
}
