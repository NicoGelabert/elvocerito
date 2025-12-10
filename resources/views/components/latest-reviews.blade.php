<section id="ultimas_reviews" class="splide">
    <div class="flex flex-col gap-8">
        <div class="container ultimas_reviews_title">
            <h3>Últimas reseñas</h3>
        </div>
        <div class="ultimas_reviews_card splide__track">
            <ul class="splide__list">
                @foreach ($ultimasReviews as $review)
                <li class="splide__slide">
                    <a >
                        <div class="pt-4">
                            <img src="{{ $review->product->image }}" alt="{{ $review->product->title }}">
                        </div>
                        <div class="ultimas_reviews_card_content">
                            <div class="header">
                                <!-- INICIO CATEGORÍAS -->
                                <div class="relative flex gap-2 items-center justify-between w-full">
                                    <h6 class="">Sobre {{ $review->product->title }}</h6>
                                    <div class="flex gap-2 items-center">
                                        <x-icons.star class="h-4 w-4 fill-amber-300" />
                                        <span class="text-sm">{{$review->rating}}</span>
                                    </div>
                                </div>
                                <!-- FIN CATEGORÍAS -->
                                <h5>
                                    {{ $review->title }}
                                </h5>
                                <p class="line-clamp-3">{{ $review->comment }}</p>
                                <p>{{ $review->created_at->translatedFormat('j \d\e F \d\e Y') }}</p>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>