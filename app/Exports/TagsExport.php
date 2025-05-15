<?php

namespace App\Exports;

use App\Models\Tag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TagsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tag::withCount(['products as published_products_count' => function($query) {
                $query->where('published', 1);
            }])
            ->where('active', true)
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Activo', 'Anunciantes asociados'];
    }

    public function map($tag): array
    {
        return [
            $tag->id,
            $tag->name,
            $tag->active ? 'Sí' : 'No',
            $tag->published_products_count,
        ];
    }
}
