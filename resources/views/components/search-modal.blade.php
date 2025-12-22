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
    
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center pt-8 md:p-6"
  >
    <x-close-button class="top-2"/>
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
      class="bg-white p-6 rounded-t-lg md:rounded-lg shadow-xl max-w-screen-xl w-full h-full overflow-auto"
    >
        <x-search></x-search>       
    </div>
  </div>
</div>
