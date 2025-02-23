<section id="categories" class="splide">
    <div class="container flex flex-col gap-12">
        <div class="categories_title">
            <h3>Categorías</h3>
            <div class="flex">
                <div class="splide__arrows  splide__arrows--ltr">
                </div>
                <x-button class="see-all" href="{{route ('categories.index')}}" >
                    Ver todas
                </x-button>
            </div>
        </div>
        <div class="categories_content splide__track">
            <ul class="splide__list">
                @foreach ($categories as $category)
                <li class="splide__slide">
                    <x-button class="bg-transparent" href="{{ 
                        $category->parent_id 
                        ? route('categories.view.subcategory', ['category' => $category->parent->slug, 'subcategory' => $category->slug]) 
                        : route('categories.view', ['category' => $category->slug]) 
                    }}">
                        <img src="{{ $category->image }}" alt="">
                        <p>{{ $category->name }}</p>
                    </x-button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>