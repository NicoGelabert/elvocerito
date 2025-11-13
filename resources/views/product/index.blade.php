<x-app-layout>
  <div id="product-index" class="relative">
    <!-- <div class="product_index_hero">
        <h2>Buscá</h3>
    </div> -->
    <product-list :initial-category='@json($category)' class="mt-8">
    </product-list>
    <contact-modal></contact-modal>
  </div>
</x-app-layout>