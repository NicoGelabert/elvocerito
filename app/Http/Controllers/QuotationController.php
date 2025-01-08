<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Events\QuotationCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationConfirmation;
use App\Mail\QuotationRequest;

class QuotationController extends Controller
{
    public function create()
    {
        return view('quotation');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'tags' => 'required|array',
            'message' => 'required|string',
        ]);

        $quotation = Quotation::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tags' => $request->tags,
            'message' => $request->message,
        ]);
        
        try {
            // Send confirmation email to the subscriber
            Mail::to($quotation->email)->send(new QuotationConfirmation($quotation));
            Mail::to('info@chimicreativo.es')->send(new QuotationRequest($quotation));

            return response()->json(['message' => 'Mensaje Enviado!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falló el envío. Por favor intente en unos minutos.'], 500);
        }
    }

}
