<section id="novedades" class="cards__section container" aria-label="Últimas novedades">
    <div class="title">
        <h3>Novedades</h3>
    </div>
    <div class="cards__list swiper news">
        <ul class="swiper-wrapper">
            @foreach($articles as $article)
            <li class="swiper-slide">
                <a href="{{ route('news.view', $article) }}" alt="{{ $article->title}}">
                    <div class="card__body">
                        <div class="card__content card__content--col">
                            <img class="card__img__rectangle" src="{{ $article->image }}" alt="{{ $article->title }}">
                            <h5>
                                {{ $article->title}}
                            </h5>
                            <p class="description">
                                {{ $article->news_lead }}
                            </p>
                        </div>
                        <hr class="divider my-2 w-full">
                        <div class="card__footer card__footer--between">
                            <!-- AUTOR -->
                            @foreach ($article->authors as $author)
                            <div class="author">
                                <img class="author__img" src="{{ $author->image }}" alt="$author->name">
                                <h6>{{ $author->name }}</h6>
                            </div>
                            @endforeach
                            <!-- FIN AUTOR -->
                            <!-- FECHA PUBLICACIÓN -->
                            <p class="published__date">{{ optional($article->created_at)->translatedFormat('j \d\e F \d\e Y') ?? 'Fecha no disponible' }}
                            <!-- FIN FECHA PUBLICACIÓN -->
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
            <!-- CARD "VER MÁS" -->
            <li class="swiper-slide card__body--cta">
                <a href="{{ route('news.index') }}">
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