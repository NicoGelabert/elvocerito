<div class="container news splide" aria-label="Latest news">
    <div class="news-title">
        <h4>News</h4>
        <x-see-all />
    </div>
    <div class="splide__track">
        <ul class="splide__list">
            @foreach($articles as $article)
            <li class="news-card splide__slide">
                <div class="news-card-img">
                    <img src="{{ $article->image }}" alt="$article->title">
                </div>
                <div class="news-card-content">
                    <div class="news-card-content-header">
                        @foreach ($article->authors as $author)
                        <div class="author">
                            <img src="{{ $author->image }}" alt="$author->name">
                            <h6>{{ $author->name }}</h6>
                        </div>
                        @endforeach
                        <p class="dot-divider">·</p>
                        <p class="news-date">{{ $article->created_at->format('M d, Y') }}</p>
                    </div>
                    <h5>{{ $article->title }}</h5>
                    <p class="description">{{ $article->news_lead }}</p>
                    <x-badge badge_title="#PalabrasDeExpertos" />
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>