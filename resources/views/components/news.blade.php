<section id="novedades" class="cards__section container" aria-label="Notas e Ideas">
    <div class="articles-title">
        <h3>Notas e Ideas</h3>
        <a href="{{ route('news.index') }}">Ver más</a>
    </div>
    <div class="cards__list swiper news">
        <ul class="swiper-wrapper">
            @foreach($articles as $article)
            <li class="swiper-slide">
                <a href="{{ route('news.view', $article) }}" alt="{{ $article->title}}">
                    <div class="card__body">
                        <div class="card__content card__content--col">
                            <div class="aspect-video">
                                <img class="card__img__rectangle" src="{{ $article->image }}" alt="{{ $article->title }}">
                            </div>
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
                            @if ($article->authors->count() === 1)
                                @foreach ($article->authors as $author)
                                    <div class="author">
                                        <img class="author__img" src="{{ $author->image }}" alt="{{ $author->name }}">
                                        <h6>{{ $author->name }}</h6>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex">
                                    @foreach ($article->authors as $author)
                                        <div class="author -ml-2 first:ml-0">
                                            <img class="author__img" src="{{ $author->image }}" alt="{{ $author->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <!-- FIN AUTOR -->
                            <!-- FECHA PUBLICACIÓN -->
                            <p class="published__date">{{ optional($article->created_at)->format('d/m/y') ?? 'Fecha no disponible' }}
                            <!-- FIN FECHA PUBLICACIÓN -->
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
            <!-- CARD "VER MÁS" -->
            <li class="swiper-slide card__body--cta">
                <a href="{{ route('news.index') }}">
                    <div class="card__body h-64">
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