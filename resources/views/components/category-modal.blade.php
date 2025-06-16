<div 
  x-data="{ isOpen: false }" 
  x-init="window.addEventListener('open-category-modal', () => isOpen = true)"
>
  <!-- Fondo + x-show controla todo -->
  <div 
    x-show="isOpen"
    
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center pt-8 md:p-6"
  >
    <!-- Modal sin x-show, solo transición -->
    <div 
      x-show="isOpen"
      x-transition:enter="transition transform duration-300"
      x-transition:enter-start="opacity-0 translate-y-full"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition transform duration-300"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 translate-y-full"
      @click.stop
      class="bg-white p-6 rounded-lg shadow-xl max-w-screen-xl w-full h-full overflow-auto"
    >
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Categorías</h2>
        <button @click="isOpen = false" class="font-bold">✖</button>
      </div>

      <!-- Contenido -->
      <ul class="grid grid-cols-2 md:grid-cols-8 gap-y-8 gap-x-2">
        @forelse ($categories as $category)
          <li>
            <x-button class="flex flex-col items-center gap-2 w-full h-full" href="{{ 
              $category->parent_id 
              ? route('categories.view.subcategory', ['category' => $category->parent->slug, 'subcategory' => $category->slug]) 
              : route('categories.view', ['category' => $category->slug]) 
            }}">
              <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-8 h-auto">
              <p class="text-xs text-center font-normal text-gray_500">{{ $category->name }}</p>
            </x-button>
          </li>
        @empty
          <li class="text-gray-500">No hay categorías disponibles.</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
