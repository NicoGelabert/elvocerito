<section id="anunciantes_destacados">
    <div class="container flex flex-col gap-8"">
        <div class="anunciantes_destacados_title">
            <h3>Anunciantes destacados</h3>
        </div>
        <div class="anunciantes_destacados_card">
            <ul>
                @foreach ($anunciantes_destacados as $anunciante_destacado)
                <li class="relative flex flex-col rounded-lg border border-gray_200 justify-between gap-4">
                    @if ($anunciante_destacado->prices)
                        <ul class="absolute top-2 left-2">
                            @foreach ($anunciante_destacado->prices as $price)
                                <li>
                                    <x-badge class="star" badge_title="{{ $price->number }}" />
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div>
                        <div>
                            <img src="{{ $anunciante_destacado->image }}" alt="{{ $anunciante_destacado->title }}">
                        </div>
                        <a href="{{ route('product.view', [
                            'category' => $anunciante_destacado->categories->first()->parent ? $anunciante_destacado->categories->first()->parent->slug : 'sin-subcategoria', // Obtiene la categoría principal
                            'subcategory' => $anunciante_destacado->categories->first()->slug, // Obtiene la subcategoría
                            'product' => $anunciante_destacado->slug // Obtiene el producto
                        ]) }}">
                            <div class="anunciantes_destacados_card_content">
                                <div class="header">
                                    <!-- INICIO CATEGORÍAS -->
                                    <div class="flex gap-2 items-center justify-between">
                                        @if ($anunciante_destacado->categories->count() > 0)
                                            @php
                                                $firstCategory = $anunciante_destacado->categories->first();
                                                $remainingCount = $anunciante_destacado->categories->count() - 1;
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
                                        {{ $anunciante_destacado->title}}
                                    </h5>
                                </div>
                                <p>{{ $anunciante_destacado->short_description }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 flex flex-col gap-2">
                        <hr class="divider">
                        <x-contact-icons class="contact-icons" :icons="[$anunciante_destacado->first_contact]"></x-contact-icons>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>