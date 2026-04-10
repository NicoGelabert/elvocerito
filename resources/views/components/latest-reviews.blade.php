<section id="ultimas_reviews" class="cards__section container">
    <div class="title">
        <h3>Últimas reseñas</h3>
    </div>
    <div class="cards__list swiper ultimas_reviews">
        <ul class="swiper-wrapper">
            @foreach ($ultimasReviews as $review)
            <li class="swiper-slide">
                <a href="{{ route('product.view', [
                        'category' => optional($review->product->categories->first())->slug ?? 'sin-categoria',
                        'product' => $review->product->slug
                    ]) }}">
                    
                    <div class="card__body">
                        <div class="card__content">
                            <div class="card__left">
                                <img class="card__img__rounded" src="{{ $review->product->image }}" alt="{{ $review->product->title }}">
                            </div>
                            <div class="card__right">
                                @php
                                    $firstCategory = $review->product->categories->first();
                                @endphp
                                <h6>{{ optional($firstCategory)->name ?? 'Sin categoría' }}</h6>
                                <h4 class="capitalize">{{ $review->product->title }}</h4>
                                <h5 class="review_title">
                                    {{ $review->title }}
                                </h5>
                                    <x-rating-stars :rating="$review->rating" />
                                <p class="description">{{ $review->comment }}</p>
                            </div>
                        </div>
                        <hr class="divider my-2 w-full">
                        <div class="card__footer card__footer--start">
                            <!-- <img src="{{ $review->product->image }}" alt="{{ $review->product->title }}"> -->
                            <x-initials-avatar
                                :name="$review->name"
                                :last-name="$review->last_name"
                                size="sm"
                            />
                            <div>
                                <h6>{{ $review->name}} {{ $review->last_name}}</h6>
                                
                                <p class="published__date">
                                    {{ optional($review->created_at)->translatedFormat('j \d\e F \d\e Y') ?? 'Fecha no disponible' }}
                                </p>
    
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</section>
<script>
      
    </script>