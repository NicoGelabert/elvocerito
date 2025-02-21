<x-app-layout>
    <div class="product-index relative">
        <div class="product_index_hero">
            <h2>Urgencias</h2>
        </div>
        <!-- Pasar productos al componente Vue -->
        <product-list :products="{{ json_encode($products) }}" :categories="{{ json_encode($categories) }}" />
    </div>
</x-app-layout>