<section id="categories">
    <div class="container flex flex-col gap-8">
        <div class="categories_title">
            <h3>Categorías</h3>
            <x-see-all />
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