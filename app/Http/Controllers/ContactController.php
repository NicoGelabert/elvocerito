<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Events\ContactCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactConfirmation;
use App\Mail\AdminNotificationMail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'service' => 'required|string',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'service' => $request->service,
            'message' => $request->message,
        ]);

        try {
            // Send confirmation email to the subscriber
            Mail::to($contact->email)->send(new ContactConfirmation($contact));
            Mail::to(config('mail.from.address'))->send(new AdminNotificationMail($contact));

            return response()->json(['message' => 'Mensaje Enviado!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falló el envío. Por favor intente en unos minutos.'], 500);
        }
    }
}
