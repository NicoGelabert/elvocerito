<x-app-layout>
  <div id="" class="relative product-index">
    <x-breadcrumbs :crumbs="[
        ['label' => 'Notas e Ideas', 'url' => route('news.index')],
        ['label' => $article->title],
    ]" />
    <product-list :initial-category='@json($category)'>
    </product-list>
    <contact-modal></contact-modal>
  </div>
</x-app-layout>