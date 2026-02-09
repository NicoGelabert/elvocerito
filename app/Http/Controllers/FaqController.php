<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('category', '!=', 'guia_usuarios')->get();

        $order = [
            'preguntas_generales',
            'guia_papel',
            'guia_digital',
            'publicidad',
        ];

        $categoryTitles = [
            'preguntas_generales' => 'Preguntas en común (revista y web)',
            'guia_papel' => 'Guía Papel',
            'guia_digital' => 'Guía Digital',
            'publicidad' => 'Publicidad en Google',
        ];

        $faqsByCategory = $faqs
            ->groupBy('category')
            ->sortBy(function ($_, $category) use ($order) {
                return array_search($category, $order);
            });

        return view('faqs.index', compact('faqsByCategory', 'categoryTitles'));
    }

    public function comoUsarLaGuia()
    {
        $faqs = Faq::where('category', 'guia_usuarios')->get();
        $faqsByCategory = $faqs->groupBy('category'); // aunque solo haya una categoría, mantiene la consistencia

        return view('about.como_usar_la_guia', compact('faqsByCategory'));
    }
}
