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
    <div class="flex flex-col md:flex-row justify-between gap-8">
        @php
        $primerArticulo = $articles->first();
        @endphp
        <a href="{{ route('news.view', $primerArticulo) }}" class="w-full md:w-1/2">
            <div class="leading_article">
                <img src="{{ $primerArticulo->image }}" alt="{{ $primerArticulo->title }}">
                <h4>{{ $primerArticulo->title }}</h4>
                <p class="news_lead">{{ $primerArticulo->news_lead }}</p>
                <hr class="divider">
                <div class="flex justify-between items-center">
                    @foreach ($primerArticulo->authors as $author)
                    <div class="author">
                        <img src="{{ $author->image }}" alt="$author->name">
                        <h6>{{ $author->name }}</h6>
                    </div>
                    @endforeach
                    <p class="news-date">{{ $primerArticulo->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </a>
        <div class="news">
            <ul class="flex flex-col gap-4">
                @foreach($articles as $article)
                <a href="{{ route('news.view', $article) }}">
                    <li class="news-card">
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
                                <p class="news-date">{{ $article->created_at->format('M d, Y') }}</p>
                            </div>
                            <!-- <p class="description">{{ $article->news_lead }}</p> -->
                            <x-badge badge_title="#PalabrasDeExpertos" />
                        </div>
                    </li>
                </a>
                @endforeach
            </ul>
        </div>
    </div>
</div>