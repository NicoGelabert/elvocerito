<section class="home-hero-banner splide container">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($homeherobanners as $homeherobanner)
            <li class="splide__slide">
                <div class="home-hero-banner-li_header">
                    <h3>{{ $homeherobanner->description }}</h3>
                </div>
                <div class="home-hero-banner-li-content">
                    <div class="flex flex-col gap-8">
                        <div class="home-hero-banner-li-content_img">
                            <img src="{{ $homeherobanner->image }}" alt="">
                        </div>
                        <h6>{{ $homeherobanner->headline }}</h6>
                        <!-- <x-button class="btn btn-primary">Ver más <x-icons.send /></x-button> -->
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>