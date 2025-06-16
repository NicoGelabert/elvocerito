
<section id="categories">
    <x-category-modal :categories="$categories" />
    <div class="categories container splide">
        <div class="flex flex-col gap-12">
            <div class="categories_title">
                <h3>Categorías</h3>
                <div class="flex">
                    <div class="splide__arrows relative splide__arrows--ltr">
                    </div>
                    <x-button class="see-all" onclick="window.dispatchEvent(new CustomEvent('open-category-modal'))">
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

<script>
    document.addEventListener('alpine:init', () => {
        window.addEventListener('category-selected', event => {
            console.log('Categoría seleccionada:', event.detail);
            // Podés usar event.detail.id y event.detail.name aquí
        });
    });
</script>