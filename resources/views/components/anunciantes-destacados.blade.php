<section id="anunciantes_destacados" class="cards__section container">
    <div class="title">
        <h3>Servicios destacados</h3>
    </div>
    <div class="cards__list swiper servicios_destacados">
        <ul class="swiper-wrapper">
            @foreach ($anunciantes_destacados as $anunciante_destacado)
            <li class="swiper-slide">
                <div class="card__body">
                    <div class="card__content">
                        <div class="card__left">
                            <img class="card__img__rounded" src="{{ $anunciante_destacado->image }}" alt="{{ $anunciante_destacado->title }}">
                        </div>
                        <div class="card__right">
                            <div class="card__info">
                                <!-- INICIO CATEGORÍA -->
                                @php
                                    $firstCategory = $anunciante_destacado->categories->first();
                                @endphp
                                <h6>{{ $firstCategory->name }}</h6>
                                <!-- FIN CATEGORÍA -->
                                <a href="{{ route('product.view', [
                                    'category' => optional($anunciante_destacado->categories->first())->slug ?? 'sin-categoria',
                                    'product' => $anunciante_destacado->slug
                                    ]) }}">
                                    <h5>
                                        {{ $anunciante_destacado->title}}
                                    </h5>
                                </a>
                                <p class="description">
                                    {{ $anunciante_destacado->short_description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card__meta">
                        <div class="badge open">
                            <span>En guía desde {{ optional($anunciante_destacado->created_at)->translatedFormat('Y') ?? 'Fecha no disponible' }}</span>
                        </div>
                        @if($anunciante_destacado->urgencies)
                            <div class="card__badges">
                                <x-badge-urgencies :product="$anunciante_destacado"/>
                            </div>
                        @endif
                        <div class="card__rating">
                            @if ($anunciante_destacado->reviews_count > 0)
                                <x-icons.star class="w-4 h-4 fill-transparent stroke-primary" />
                                <span class="font-bold text-base text-secondary leading-none pt-[0.1rem]">{{ $anunciante_destacado->average_rating }}</span>

                                <span class="text-xs text-primary italic leading-none pt-[0.1rem]">
                                    ({{ $anunciante_destacado->reviews_count }})
                                </span>
                            @else
                                <x-icons.star class="w-4 h-4 fill-transparent stroke-gray-500" />
                                <span class="text-xs text-gray-500 leading-none pt-[0.1rem]">0</span>
                            @endif
                        </div>
                    </div>
                    <hr class="divider my-2 w-full">
                    <div class="card__footer card__footer--between">
                        <!-- INICIO VÍAS DE CONTACTO -->
                        <x-button 
                            class="btn btn-primary"
                            onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                detail: { type: 'contact', id: {{ $anunciante_destacado->id }} }
                            }))"
                            >
                            Contactar
                        </x-button>
                        <!-- FIN VÍAS DE CONTACTO -->
                        <!-- INICIO VER SERVICIO -->
                        <x-button 
                            class="btn btn-secondary"
                            onclick="window.location.href='{{ route('product.view', [
                                'category' => optional($anunciante_destacado->categories->first())->slug ?? 'sin-categoria',
                                'product' => $anunciante_destacado->slug
                            ]) }}'"
                            >
                            Ver +
                        </x-button>
                        <!-- FIN VER SERVICIO -->
                    </div>
                </div>
            </li>
            @endforeach
            <!-- CARD "VER MÁS" -->
            <li class="swiper-slide card__body--cta">
                <a href="/anunciantes?page=1">
                    <div class="card__body h-48">
                        <div class="card__content card__content--col card__content--center card__content--justify__center">
                            <div class="card__plus">
                                +
                            </div>
                            <h5>Ver más</h5>
                        </div>                        
                    </div>
                </a>
            </li>
        </ul>
    </div>
</section>