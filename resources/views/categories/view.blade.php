<x-app-layout>
    <div class="category_view product-index">
        <!-- INICIO BREADCRUMBS -->
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
                <h2 class="text-small">{{ $category->name }}</h2>
            </div>
        </div>
        <!-- FIN BREADCRUMBS -->

        @if ($products->isNotEmpty())
            <div class="flex gap-6 container">
                <div class="hidden lg:block w-1/3">

                </div>
                <div class="my-10 w-full lg:w-2/3">
                    <h3>{{ $category->name }}</h3>
                </div>
            </div>
            <product-list :products='@json($products)' :categories='@json($subcategories)' :tags='@json($tags)' />
        @else
            <p class="text-center">No hay Anunciantes para esta categoría</p>
        @endif
    </div>
</x-app-layout>
