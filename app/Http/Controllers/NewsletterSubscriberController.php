<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterAdminMail;
use App\Mail\NewsletterWelcomeMail;
use Illuminate\Support\Str;

class NewsletterSubscriberController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot anti-spam
        if ($request->filled('company')) {
            return response()->json([
                'message' => 'Spam detectado'
            ], 422);
        }

        $request->validate([
            'email' => 'required|email'
        ]);

        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => Str::random(40),
                'unsubscribe_token' => Str::random(40),
                'confirmed' => false,
                'unsubscribed_at' => null,
            ]
        );

        // Mail admin
        Mail::to(config('mail.from.address'))
            ->queue(new NewsletterAdminMail($subscriber));

        // Mail usuario
        Mail::to($subscriber->email)
            ->queue(new NewsletterWelcomeMail($subscriber));

        return response()->json([
            'message' => 'Revisa tu email para confirmar la suscripción 📩'
        ]);
    }

    public function confirm($token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->firstOrFail();

        $subscriber->update([
            'confirmed' => true,
            'confirmed_at' => now(),
            'token' => null
        ]);

        return redirect('/')->with('success', 'Suscripción confirmada ✅');
    }

    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where(
            'unsubscribe_token',
            $token
        )->firstOrFail();

        $subscriber->update([
            'confirmed' => false,
            'unsubscribed_at' => now(),
        ]);

        return redirect('/')
            ->with('success', 'Te desuscribiste correctamente.');
    }
}
