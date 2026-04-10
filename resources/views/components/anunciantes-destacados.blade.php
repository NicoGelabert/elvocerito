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
                            <div class="badge open">
                                <span>Desde {{ optional($anunciante_destacado->created_at)->translatedFormat('Y') ?? 'Fecha no disponible' }}</span>
                            </div>
                        </div>
                        <div class="card__right">
                            <div class="card__info">
                                <!-- INICIO CATEGORÍA -->
                                @php
                                    $firstCategory = $anunciante_destacado->categories->first();
                                @endphp
                                <h6>{{ $firstCategory->name }}</h6>
                                <!-- FIN CATEGORÍA -->
                                <h5>
                                    {{ $anunciante_destacado->title}}
                                </h5>
                                <p class="description {{ ($anunciante_destacado->reviews_count > 0 || $anunciante_destacado->urgencies) ? '!line-clamp-2' : 'line-clamp-3' }}">
                                    {{ $anunciante_destacado->short_description }}
                                </p>
                            </div>
                            @if ($anunciante_destacado->reviews_count > 0 || $anunciante_destacado->urgencies)
                            <div class="card__meta">
                                @if ($anunciante_destacado->reviews_count > 0)
                                <div class="card__rating">
                                    @php
                                        $average = \App\Models\Review::where('product_id', $anunciante_destacado->id)
                                            ->where('published', true)
                                            ->where('email_verified', true)
                                            ->avg('rating');
                                        $average = $average ? round($average, 1) : null;
                                    @endphp

                                    @if($average)
                                        <x-icons.star class="w-4 h-4 fill-amber-300" />
                                        <span class="font-semibold text-xs text-gray-500">{{ $average }}</span>
                                    @endif

                                    <span class="text-xs text-gray-500">
                                        ({{ $anunciante_destacado->reviews_count }})
                                    </span>
                                </div>
                                @endif

                                @if($anunciante_destacado->urgencies)
                                <div class="card__badges">
                                    <x-badge-urgencies :product="$anunciante_destacado"/>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    <hr class="divider my-2 w-full">
                    <div class="card__footer card__footer--between">
                        <!-- INICIO VÍAS DE CONTACTO -->
                        <x-button 
                            class="btn btn-primary"
                            onclick="window.location.href='{{ route('product.view', [
                                'category' => optional($anunciante_destacado->categories->first())->slug ?? 'sin-categoria',
                                'product' => $anunciante_destacado->slug
                            ]) }}'"
                            >
                            Ver servicio
                        </x-button>
                        <!-- FIN VÍAS DE CONTACTO -->
                        <!-- INICIO VÍAS DE CONTACTO -->
                        <x-button 
                            class="btn btn-secondary"
                            onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                detail: { type: 'contact', id: {{ $anunciante_destacado->id }} }
                            }))"
                            >
                            Contactar
                        </x-button>
                        <!-- FIN VÍAS DE CONTACTO -->
                    </div>
                </div>
            </li>
            @endforeach
            <!-- CARD "VER MÁS" -->
            <li class="swiper-slide card__body--cta">
                <a href="/anunciantes?page=1">
                    <div class="card__body">
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