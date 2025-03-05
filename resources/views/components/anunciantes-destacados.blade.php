<section id="anunciantes_destacados">
    <div class="container flex flex-col gap-8"">
        <div class="products_title">
            <h3>Anunciantes destacados</h3>
        </div>
        <div class="products_card">
            <ul>
                @foreach ($anunciantes_destacados as $anunciante_destacado)
                <li class="relative flex flex-col rounded-lg border border-gray_200">
                    @if ($anunciante_destacado->prices)
                        <ul class="absolute top-2 left-2">
                            @foreach ($anunciante_destacado->prices as $price)
                                <li>
                                    <x-badge class="star" badge_title="{{ $price->number }}" />
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <img src="{{ $anunciante_destacado->image }}" alt="{{ $anunciante_destacado->title }}">
                    <div class="products_card_content">
                        @foreach ($anunciante_destacado->categories as $category)
                        <x-badge badge_title="{{ $category->name }}" class="truncate-text" />
                        @endforeach
                        
                        <a href="{{ route('product.view', [
                            'category' => $anunciante_destacado->categories->first()->parent ? $anunciante_destacado->categories->first()->parent->slug : 'sin-subcategoria', // Obtiene la categoría principal
                            'subcategory' => $anunciante_destacado->categories->first()->slug, // Obtiene la subcategoría
                            'product' => $anunciante_destacado->slug // Obtiene el producto
                        ]) }}">
                            <h5>
                                {{ $anunciante_destacado->title}}
                            </h5>
                        </a>
                        <p>{{ $anunciante_destacado->short_description }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>