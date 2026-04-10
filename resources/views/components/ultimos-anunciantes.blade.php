<section id="ultimos_anunciantes" class="cards__section container">
    <div class="title">
        <h3>Nuevos servicios</h3>
    </div>
    <div class="cards__list swiper nuevos_servicios">
        <ul class="swiper-wrapper">
            @foreach ($ultimos_anunciantes as $ultimo_anunciante)
            <li class="swiper-slide">
                <a href="{{ route('product.view', [
                    'category' => optional($ultimo_anunciante->categories->first())->slug ?? 'sin-categoria',
                    'product' => $ultimo_anunciante->slug
                ]) }}">
                    <div class="card__body">
                        <div class="card__content">
                            <div class="card__left">
                                <img class="card__img__rounded" src="{{ $ultimo_anunciante->image }}" alt="{{ $ultimo_anunciante->title }}">
                            </div>
                            <div class="card__right">
                                <div class="card__info">
                                    @php
                                        $firstCategory = $ultimo_anunciante->categories->first();
                                    @endphp
                                    <h6 class="truncate-text z-[1]">
                                        {{ $firstCategory->name }}
                                    </h6>
                                    <h5>
                                        {{ $ultimo_anunciante->title }}
                                    </h5>
                                    <p class="published__date">
                                        {{ optional($ultimo_anunciante->created_at)->translatedFormat('j \d\e F \d\e Y') ?? 'Fecha no disponible' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</section>