<section class="home-hero-banner splide container">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($homeherobanners as $homeherobanner)
            <li class="splide__slide">
                <a href="{{ $homeherobanner->link }}">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="homeherobanner_img">
                            <img src="{{ $homeherobanner->image }}" alt="">
                        </div>
                        <div class="homeherobanner_content">
                            <h5>{{ $homeherobanner->headline }}</h5>
                            <h3>{{ $homeherobanner->description }}</h3>
                            <p>{{ $homeherobanner->short_description }}</p>
                            <div class="flex flex-wrap gap-4">
                                @foreach ($homeherobanner->tags as $tag)
                                <x-badge badge_title="{{ $tag->name }}"/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</section>