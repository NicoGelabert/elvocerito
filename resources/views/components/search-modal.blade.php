<div 
  x-data="{ isOpen: false }" 
  x-init="window.addEventListener('open-search-modal', () => isOpen = true)"
>
  <!-- Fondo + x-show controla todo -->
  <div 
    x-show="isOpen"
    
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center pt-8 md:p-6"
  >
    <button x-show="isOpen" @click="isOpen = false" class="absolute right-2 top-2 font-bold w-12 h-12 bg-gray_200 rounded-full z-50"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">✖</button>
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
      class="bg-white p-6 rounded-t-lg md:rounded-lg shadow-xl max-w-screen-xl w-full h-full overflow-auto"
    >
        <x-search></x-search>       
    </div>
  </div>
</div>
