<section id="ultimas_reviews" class="splide">
    <div class="container flex flex-col gap-8">
        <div class="ultimas_reviews_title">
            <h3>Últimas reseñas</h3>
        </div>
        <div class="ultimas_reviews_list splide__track">
            <ul class="splide__list">
                @foreach ($ultimasReviews as $review)
                <li class="splide__slide">
                    <a href="{{ route('product.view', [
                            'category' => optional($review->product->categories->first())->slug ?? 'sin-categoria',
                            'product' => $review->product->slug
                        ]) }}">
                        <div class="relative flex gap-2 items-center w-full pt-4">
                            <!-- <img src="{{ $review->product->image }}" alt="{{ $review->product->title }}"> -->
                            <x-initials-avatar
                                :name="$review->name"
                                :last-name="$review->last_name"
                                size="lg"
                            />
                            <div>
                                <h5 class="capitalize">{{ $review->name}} {{ $review->last_name}}</h5>
                                <x-rating-stars :rating="$review->rating" />
                                <p class="text-gray_400 text-xs font-medium">{{ $review->created_at->translatedFormat('j \d\e F \d\e Y') }}</p>
                            </div>
                        </div>
                        <div class="ultimas_reviews_card_content">
                            <div class="header">
                                <h5 class="review_title">
                                    {{ $review->title }}
                                </h5>
                                <p class="line-clamp-3">{{ $review->comment }}</p>
                                <hr class="my-2">
                                <h6>Sobre {{ $review->product->title }}</h6>
                                @php
                                    $firstCategory = $review->product->categories->first();
                                @endphp
                                <p>Categoría: {{ optional($firstCategory)->name ?? 'Sin categoría' }}</p>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>