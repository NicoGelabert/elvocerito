<h2>Resultados de búsqueda para "{{ $query }}"</h2>
<ul>
    @forelse ($products as $product)
        <li class="flex items-center gap-4 mb-4">
            <img src="{{ $product->image }}" alt="{{ $product->title }}" >
            
            <div>
                <h6 class="font-bold">{{ $product->title }}</h6>
                <p class="text-sm text-gray-600">{{ $product->short_description }}</p>

                @if ($product->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-1 text-xs text-gray-500 mt-1">
                        @foreach ($product->categories as $category)
                            <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $category->name }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </li>
    @empty
        <li>No se encontraron resultados.</li>
    @endforelse
</ul>
