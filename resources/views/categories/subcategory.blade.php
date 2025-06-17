<x-app-layout>
    <div class="category_view product-index">
        <div class="breadcrumbs">
            <div class="container flex gap-2 items-center">
                <a href="/">
                    <x-icons.home class="fill-gray_400" />
                </a>
                <p>/</p>
                <a href="/categorias">
                    <p class="hidden md:block">Categorías</p>
                    <p class="md:hidden">...</p>
                </a>
                <p>/</p>
                <x-button href="{{route ('categories.view', [ 'category' => $category->slug])}}" class="bg-none">
                    <p>{{ $category->name }}</p>
                </x-button>
                <p>/</p>
                <h2 class="text-small">{{ $subcategory->name }}</h2>
            </div>
        </div>
        
        @if ($products->isNotEmpty())
            <div class="flex gap-6 container">
                <div class="hidden lg:block w-1/3">

                </div>
                <div class="my-10 w-full lg:w-2/3">
                    <h3>{{ $subcategory->name }}</h3>
                </div>
            </div>
            <product-list :products='@json($products)' :tags='@json($tags)' />
        @else
            <p class="text-center">No hay Anunciantes para esta categoría</p>
        @endif
    </div>
</x-app-layout>