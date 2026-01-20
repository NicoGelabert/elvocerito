<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActiveProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $products = Product::with(['categories', 'tags'])
        ->where('published', true)
        ->get();

        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'client_number' => $product->client_number,
                'title' => $product->title,
                'published' => $product->published ? 'Sí' : 'No',
                'leading_home' => $product->leading_home ? 'Sí' : 'No',
                'leading_category' => $product->leading_category ? 'Sí' : 'No',
                'urgencies' => $product->urgencies ? 'Sí' : 'No',
                'categories' => $product->categories->pluck('name')->implode(', '),
                'tags' => $product->tags->pluck('name')->implode(', '),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente Nº',
            'Título',
            'Publicado',
            'Lidera en Home',
            'Lidera en categoría',
            'Urgencias',
            'Categorías',
            'Tags',
        ];
    }
}
