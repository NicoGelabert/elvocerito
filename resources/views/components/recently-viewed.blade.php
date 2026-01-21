<section class="recientemente_vistos">
    <div class="container flex flex-col gap-6">
        <div class="title">
            <h3>Vistos recientemente</h3>
        </div>
        @if($viewedCategories->isNotEmpty())
        <div id="categorias_recientemente_vistas" class="categorias_recientemente_vistas splide">
            <h4 class="title">Categorías</h4>
                <div class="splide__track cards">
                    <ul class="splide__list">
                        @foreach($viewedCategories as $category)
                            <li class="splide__slide">
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}">
                                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-6 h-6">
                                    <p>{{ $category->name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($viewedProducts->isNotEmpty())
        <div id="productos_recientemente_vistos" class="anunciantes_recientemente_vistos splide flex flex-col gap-4">
            <h4 class="title">Anunciantes</h4>
            <div class="recientemente_vistos_card splide__track">
                <ul class="splide__list">
                    @foreach ($viewedProducts as $viewedProduct)
                    <li class="splide__slide">
                        <a href="{{ route('product.view', [
                            'category' => $viewedProduct->categories->first()->parent ? $viewedProduct->categories->first()->parent->slug : 'sin-subcategoria', // Obtiene la categoría principal
                            'subcategory' => $viewedProduct->categories->first()->slug, // Obtiene la subcategoría
                            'product' => $viewedProduct->slug // Obtiene el producto
                        ]) }}">
                            <div>
                                <img src="{{ $viewedProduct->image }}" alt="{{ $viewedProduct->title }}">
                            </div>
                            <div class="recientemente_vistos_card_content">
                                <div class="header">
                                    <!-- INICIO CATEGORÍAS -->
                                    <div class="relative flex gap-2 items-center justify-between md:w-fit ">
                                        @if ($viewedProduct->categories->count() > 0)
                                            @php
                                                $firstCategory = $viewedProduct->categories->first();
                                                $remainingCount = $viewedProduct->categories->count() - 1;
                                            @endphp
                                            
                                            <h6 class="truncate-text z-[1]">{{ $firstCategory->name }}</h6>
                                            
                                            @if ($remainingCount > 0)
                                                <span class="remaining-count">
                                                    +{{ $remainingCount }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <!-- FIN CATEGORÍAS -->
                                    <h5>
                                        {{ $viewedProduct->title }}
                                    </h5>
                                </div>
                                <p>{{ $viewedProduct->short_description }}</p>
                                <!-- @if($viewedProduct->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($viewedProduct->tags as $tag)
                                    <x-badge badge_title="{{ $tag->name }}"/>
                                    @endforeach
                                </div>
                                @endif -->
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</section>