<div class="container" aria-label="Latest news">
    <div class="news-title">
        <h3>Novedades</h3>
        <div class="flex">
            <div class="splide__arrows  splide__arrows--ltr">
            </div>
            <x-button class="see-all" href="{{route ('products.index')}}" >
                Ver todas
            </x-button>
        </div>
    </div>
    <div class="flex">
        <div class="w-1/2">

        </div>
        <div class="news splide">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($articles as $article)
                    <li class="news-card splide__slide">
                        <a href="{{ route('news.view', $article) }}">
                            <div class="flex gap-4 p-6 bg-white rounded-xl">
                                <div class="news-card-img">
                                    <img src="{{ $article->image }}" alt="$article->title">
                                </div>
                                <div class="news-card-content">
                                    <h5>{{ $article->title }}</h5>
                                    <div class="news-card-content-header">
                                        <div>
                                            @foreach ($article->authors as $author)
                                            <div class="author">
                                                <img src="{{ $author->image }}" alt="$author->name">
                                                <h6>{{ $author->name }}</h6>
                                            </div>
                                            @endforeach
                                        </div>
                                        <p class="dot-divider">·</p>
                                        <p class="news-date">{{ $article->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <!-- <p class="description">{{ $article->news_lead }}</p> -->
                                    <x-badge badge_title="#PalabrasDeExpertos" />
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>