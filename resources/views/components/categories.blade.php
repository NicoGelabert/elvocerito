<section id="categories">
    <div class="container flex flex-col gap-8">
        <div class="categories_title">
            <h3>Categorías</h3>
            <x-button class="see-all" href="{{route ('products.index')}}" >
                Ver todas
            </x-button>
        </div>
        <div class="categories_content">
            <ul>
                @foreach ($categories as $category)
                <li><img src="{{ $category->image }}" alt=""> <p>{{ $category->name }}</p></li>
                @endforeach
            </ul>
        </div>

    </div>
</section>