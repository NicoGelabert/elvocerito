<x-app-layout>
    <div class="category_view product-index">
        <!-- INICIO BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container flex gap-2 items-center">
                <a href="/">
                    <x-icons.home class="fill-gray_400" />
                </a>
                <p>/</p>
                <a href="/servicios">
                    <p class="hidden md:block">Categorías</p>
                    <p class="md:hidden">...</p>
                </a>
                <p>/</p>
                <h2 class="text-small">{{ $category->name }}</h2>
            </div>
        </div>
        <!-- FIN BREADCRUMBS -->

        <product-list 
            :initial-category='@json($category->slug)'
            base-url="{{ url()->current() }}"
            :show-category-filter="false"
            :show-pagination="false"
            :title='@json($category->name)'>
        </product-list>
    </div>
</x-app-layout>
