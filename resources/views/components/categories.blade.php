
<section id="categories">
    <x-category-modal :categories="$categories" />
    <div class="categories container">
        <div class="flex flex-col gap-12">
            <div class="categories_title">
                <h3>Categorías</h3>
                <div class="flex">
                    
                    <x-button class="see-all" onclick="window.dispatchEvent(new CustomEvent('open-category-modal'))">
                        Ver todas
                    </x-button>
                </div>
            </div>
        </div>
        <!-- Orden de categorías
        1 3 5
        2 4 6 -->
        @php
            $ordered = [];
            $rows = 2;
            $cols = ceil(count($categories) / $rows);

            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $cols; $j++) {
                    $index = $j * $rows + $i;
                    if (isset($categories[$index])) {
                        $ordered[] = $categories[$index];
                    }
                }
            }
        @endphp
        <div class="categories_content swiper">
            <ul class="swiper-wrapper">
                @foreach ($ordered as $category)
                <li class="swiper-slide">
                    <x-button class="bg-transparent" href="{{ route('categories.view', ['category' => $category->slug]) }}">
                        <img src="{{ $category->image }}" alt="">
                        <p>{{ $category->name }}</p>
                    </x-button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>