<section id="ultimos_anunciantes" class="splide">
    <div class="flex flex-col gap-8">
        <div class="container ultimos_anunciantes_title">
            <h3>Últimos anunciantes</h3>
        </div>
        <div class="ultimos_anunciantes_card splide__track">
            <ul class="splide__list">
                @foreach ($ultimos_anunciantes as $ultimo_anunciante)
                <li class="splide__slide">
                    <a href="{{ route('product.view', [
                        'category' => optional($ultimo_anunciante->categories->first())->slug ?? 'sin-categoria',
                        'product' => $ultimo_anunciante->slug
                    ]) }}">
                        <div>
                            <img src="{{ $ultimo_anunciante->image }}" alt="{{ $ultimo_anunciante->title }}">
                        </div>
                        <div class="ultimos_anunciantes_card_content">
                            <div class="header">
                                <!-- INICIO CATEGORÍAS -->
                                <div class="flex gap-2 items-center justify-between">
                                    @if ($ultimo_anunciante->categories->count() > 0)
                                        @php
                                            $firstCategory = $ultimo_anunciante->categories->first();
                                            $remainingCount = $ultimo_anunciante->categories->count() - 1;
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
                                    {{ $ultimo_anunciante->title }}
                                </h5>
                                <p>{{ $ultimo_anunciante->created_at->translatedFormat('j \d\e F \d\e Y') }}</p>
                            </div>
                            <!-- <div>
                                <p>{{ $ultimo_anunciante->short_description }}</p>
                            </div> -->
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>