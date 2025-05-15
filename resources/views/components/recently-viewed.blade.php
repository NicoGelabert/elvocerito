@if($viewedProducts->count() > 0)
<section id="recientemente_vistos" class="splide">
    <div class="flex flex-col gap-8">
        <div class="container recientemente_vistos_title">
            <h3>Vistos recientemente</h3>
        </div>
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
                                <div class="flex gap-2 items-center justify-between">
                                    @if ($viewedProduct->categories->count() > 0)
                                        @php
                                            $firstCategory = $viewedProduct->categories->first();
                                            $remainingCount = $viewedProduct->categories->count() - 1;
                                        @endphp
                                        
                                        <h6 class="truncate-text">{{ $firstCategory->name }}</h6>
                                        
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
</section>
@endif