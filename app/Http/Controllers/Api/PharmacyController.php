<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    // GET /pharmacies-with-products
    public function withProducts()
    {
        $pharmacies = Pharmacy::with('product')->get();

        return response()->json($pharmacies);
    }
}
