<x-app-layout>
  <div id="product-index" class="relative">
    <!-- INICIO BREADCRUMBS -->
    <div class="breadcrumbs">
        <div class="container flex gap-2 items-center">
            <a href="/">
                <x-icons.home class="fill-gray_400" />
            </a>
            <p>/</p>
            <h2 class="text-small">Buscador</h2>
        </div>
    </div>
    <!-- FIN BREADCRUMBS -->
    <product-list :initial-category='@json($category)'>
    </product-list>
    <contact-modal></contact-modal>
  </div>
</x-app-layout>