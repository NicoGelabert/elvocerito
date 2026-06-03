<x-app-layout>
    <div class="category_view product-index">
        <x-breadcrumbs :crumbs="[
            ['label' => 'Servicios', 'url' => route('categories.index')],
            ['label' => $category->name, 'url' => ''],
        ]" />

        <product-list 
            initial-category="{{ $category->slug }}"
            base-url="{{ url()->current() }}"
            :show-category-filter="false"
            :show-pagination="false"
            :title='@json($category->name)'>
        </product-list>
        <contact-modal></contact-modal>
    </div>
</x-app-layout>
