<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewVerificationMail;
use App\Mail\NewReviewNotification;

class ReviewController extends Controller
{
    /**
     * Crear nueva review y enviar email de verificación
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|numeric|min:0|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        // Crear review con token
        $review = Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'title' => $request->title,
            'token' => Str::uuid(),
        ]);

        // Enviar email de verificación al usuario
        Mail::to($review->email)->send(new ReviewVerificationMail($review));

        return response()->json([
            'message' => 'Review creada correctamente. Revisa tu email para verificarla.'
        ]);
    }

    /**
     * Verificar review por token
     */
    public function verify($token)
    {
        try {
            $review = Review::where('token', $token)->firstOrFail();

            if ($review->email_verified) {
                return view('review-verify', [
                    'message' => 'La review ya fue verificada.',
                    'error' => false
                ]);
            }

            $review->email_verified = true;
            $review->save();

            // Notificar al anunciante
            $recipient = $review->product->email ?? 'admin@example.com';
            Mail::to($recipient)->send(new NewReviewNotification($review));

            return view('reviews/review-verify', [
                'message' => 'Gracias, tu review ha sido verificada y será revisada por el administrador.',
                'error' => false
            ]);

        } catch (\Exception $e) {
            // Si no se encuentra el token o hay otro error
            return view('/reviews/review-verify', [
                'message' => 'El token de verificación no es válido.',
                'error' => true
            ]);
        }
    }


    /**
     * Listar reviews pendientes de publicación (para admin)
     */
    public function adminIndex()
    {
        $reviews = Review::where('email_verified', true)
                         ->where('published', false)
                         ->with('product')
                         ->get();

        return response()->json($reviews);
    }

    /**
     * Publicar una review (admin)
     */
    public function publish($id)
    {
        $review = Review::findOrFail($id);
        $review->published = true;
        $review->save();

        return response()->json(['message' => 'Review publicada correctamente.']);
    }

    public function respond(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $review = Review::findOrFail($id);
        $review->admin_response = $request->response;
        $review->save();

        return response()->json(['message' => 'Respuesta guardada correctamente.']);
    }

    public function publicReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)
                        ->where('published', true)
                        ->with('product')
                        ->get();

        return response()->json($reviews);
    }

}
