<section id="categories">
    <div class="categories splide">
        <div class="container flex flex-col gap-12">
            <div class="categories_title">
                <h3>Categorías</h3>
                <div class="flex">
                    <div class="splide__arrows relative splide__arrows--ltr">
                    </div>
                    <x-button class="see-all" href="{{route ('categories.index')}}" >
                        Ver todas
                    </x-button>
                </div>
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
<style>
    hr{
        border:         none;
        border-left:    1px solid hsla(200, 10%, 50%,100);
        height:         100%;
        width:          1px;
}
</style>