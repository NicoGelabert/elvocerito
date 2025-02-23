<x-app-layout>
    <div class="category_view product-index">
        <div class="category_view_header">
            <h2>{{ $category->name }}</h2>
        </div>

        <!-- Aquí pasamos las subcategorías y los productos al componente Vue -->
        <product-list :products='@json($products)' :categories='@json($subcategories)' />
    </div>
</x-app-layout>
