<section class="home-hero-banner splide container">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($homeherobanners as $homeherobanner)
            <li class="splide__slide" style=" background-color:#000; background-image: url('{{ asset($homeherobanner->image) }}')">
                <div class="home-hero-banner-li-content">
                    <h2>{{ $homeherobanner->headline }}</h2>
                    <p class="text-large">{{ $homeherobanner->description }}</p>
                    <x-button class="btn btn-primary">Ver más <x-icons.send /></x-button>
                </div>
                <div class="home-hero-banner-li-overlay"></div>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="splide__pagination"></div>
</section>