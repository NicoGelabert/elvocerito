<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport  implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::with('parent')
        ->withCount(['products as published_products_count' => function($query) {
            $query->where('published', 1);  // Filtrar solo productos publicados (1 o true)
        }])
        ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Activo', 'Categoría Padre', 'Anunciantes Activos'];
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->name,
            $category->active ? 'Sí' : 'No',
            $category->parent ? $category->parent->name : 'Categoría Principal',
            $category->published_products_count,
        ];
    }
}
