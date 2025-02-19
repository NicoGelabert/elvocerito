<section id="ultimos_anunciantes" class="splide">
    <div class="flex flex-col gap-8">
        <div class="container ultimos_anunciantes_title">
            <h3>Últimos anunciantes</h3>
        </div>
        <div class="ultimos_anunciantes_card splide__track">
            <ul class="splide__list">
                @foreach ($ultimos_anunciantes as $ultimo_anunciante)
                <li class="splide__slide">
                    <img src="{{ $ultimo_anunciante->image }}" alt="{{ $ultimo_anunciante->title }}">
                    <div class="ultimos_anunciantes_card_content">
                        @foreach ($ultimo_anunciante->categories as $category)
                        <x-badge badge_title="{{ $category->name }}" class="truncate-text" />
                        @endforeach
                        <h5><a href="{{ route('product.view', ['category' => $ultimo_anunciante->categories->first()->slug, 'product' => $ultimo_anunciante->slug]) }}">{{ $ultimo_anunciante->title}}</a></h5>
                        <p>{{ $ultimo_anunciante->short_description }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>