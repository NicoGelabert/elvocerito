<x-app-layout>
    <div class="category_view product-index">
        <div class="category_view_header">
            <h2>{{ $subcategory->name }}</h2>
        </div>
        
        @if ($products->isNotEmpty())
            <product-list :products='@json($products)' :tags='@json($tags)' />
        @else
            <p class="text-center">No hay Anunciantes para esta categoría</p>
        @endif
    </div>
</x-app-layout>