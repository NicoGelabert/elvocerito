<h2>Resultados de búsqueda para "{{ $query }}"</h2>
<ul>
    @forelse ($products as $product)
        <li>{{ $product->title }}</li>
    @empty
        <li>No se encontraron resultados.</li>
    @endforelse
</ul>
