<section id="recientemente_vistos" class="cards__section container">
    <div class="title">
        <h3>Vistos recientemente</h3>
    </div>
    @if($viewedCategories->isNotEmpty())
    <div class="categorias_recientemente_vistas">
        <h4 class="title">Categorías</h4>
        <div class="cards__list swiper categorias_vistas">
            <ul class="swiper-wrapper">
                @foreach($viewedCategories as $category)
                    <li class="swiper-slide">
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}">
                            <div class="card__body">
                                <div class="card__content card__content--center">
                                    <div class="card__left">
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-6 h-6">
                                    </div>
                                    <div class="card__right">
                                        <p>{{ $category->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    @if($viewedProducts->isNotEmpty())
    <div class="anunciantes_recientemente_vistos">
        <h4 class="title">Servicios</h4>
        <div class="cards__list swiper servicios_vistos">
            <ul class="swiper-wrapper">
                @foreach ($viewedProducts as $viewedProduct)
                <li class="swiper-slide">
                    <a href="{{ route('product.view', [
                    'category' => optional($viewedProduct->categories->first())->slug ?? 'sin-categoria',
                    'product' => $viewedProduct->slug
                    ]) }}">
                        <div class="card__body">
                            <div class="card__content">
                                <div class="card__left">
                                    <img class="card__img__rounded" src="{{ $viewedProduct->image }}" alt="{{ $viewedProduct->title }}">
                                </div>
                                <div class="card__right">
                                    <div class="card__info">
                                        <!-- INICIO CATEGORÍA -->
                                        @php
                                            $firstCategory = $viewedProduct->categories->first();
                                        @endphp
                                        <h6>{{ $firstCategory->name }}</h6>
                                        <!-- FIN CATEGORÍA -->
                                        <h5>
                                            {{ $viewedProduct->title}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</section>