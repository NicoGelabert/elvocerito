<x-app-layout>
    <div class="category_view product-index">
        <div class="category_view_header">
            <h2>{{ $subcategory->name }}</h2>
        </div>
        @foreach ($products as $product)
        {{ $product->title}}
        @endforeach
        <product-list :products="$products" />
    </div>
</x-app-layout>