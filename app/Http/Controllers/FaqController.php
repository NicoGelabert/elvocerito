<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('category', '!=', 'guia_usuarios')->get();
        $faqsByCategory = $faqs->groupBy('category');

        return view('faqs.index', compact('faqsByCategory'));
    }

    public function comoUsarLaGuia()
    {
        $faqs = Faq::where('category', 'guia_usuarios')->get();
        $faqsByCategory = $faqs->groupBy('category'); // aunque solo haya una categoría, mantiene la consistencia

        return view('about.como_usar_la_guia', compact('faqsByCategory'));
    }
}
