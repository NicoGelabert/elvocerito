@props(['viewedProducts', 'viewedCategories', 'anunciantes_destacados'])
<div 
  x-data="{ isOpen: false }" 
  x-init="
    window.addEventListener('open-search-modal', () => {
      isOpen = true
      if (window.innerWidth >= 768) {
        $nextTick(() => $refs.searchInput.focus())
      }
    })
  "
>
  <!-- Fondo + x-show controla todo -->
  <div 
    x-show="isOpen"
    
    class="bg-popup flex items-center justify-center pt-8 md:p-6"
  >
    <div class="search-modal">
      <x-close-button />
      <!-- Modal sin x-show, solo transición -->
      <div 
        x-show="isOpen"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="opacity-0 translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full"
        @click.once="$refs.searchInput.focus()"
        @click.stop
        class="bg-white p-6 rounded-t-lg md:rounded-lg shadow-xl w-full h-full overflow-auto"
      >
      
      <x-search :viewedProducts="$viewedProducts" :viewedCategories="$viewedCategories" :anunciantes_destacados="$anunciantes_destacados"></x-search>
      </div>
    </div>
  </div>
</div>
