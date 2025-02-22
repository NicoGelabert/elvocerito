<section id="categories" class="splide">
    <div class="container flex flex-col gap-12">
        <div class="categories_title">
            <h3>Categorías</h3>
            <div class="flex">
                <div class="splide__arrows  splide__arrows--ltr">
                </div>
                <x-button class="see-all" href="{{route ('products.index')}}" >
                    Ver todas
                </x-button>
            </div>
        </div>
        <div class="categories_content splide__track">
            <ul class="splide__list">
                @foreach ($categories as $category)
                <li class="splide__slide"><img src="{{ $category->image }}" alt=""> <p>{{ $category->name }}</p></li>
                @endforeach
            </ul>
        </div>
    </div>
</section>