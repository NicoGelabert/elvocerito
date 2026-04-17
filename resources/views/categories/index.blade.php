@props(['viewedProducts', 'viewedCategories', 'anunciantes_destacados'])
<x-app-layout>
    <div class="categories_index">
        <x-search-hero />
        <div class="container" >
            <div class="categories_index_hero">
                <h3>Categorías</h3>
            </div>
            <div>
                <ul class="masonry">
                    @foreach($categories as $category)
                        <li class="item">
                            <x-button href="{{route ('categories.view', [ 'category' => $category->slug])}}">
                                <div class="item_header">
                                    <h5>{{ $category->name }}</h5>
                                    <img src="{{ $category->image }}" alt="">
                                </div>
                            </x-button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
