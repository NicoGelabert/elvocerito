<div 
  x-data="{ isOpen: false, }" 
  x-init="
    window.addEventListener('open-search-modal', () => {
      isOpen = true
      document.body.style.overflow = 'hidden'
      if (window.innerWidth >= 768) {
        $nextTick(() => $refs.searchInput.focus())
      }
    });
    window.addEventListener('close-search-modal', () => {
      isOpen = false
      document.body.style.overflow = ''
    })
  "
>
  <!-- Fondo + x-show controla todo -->
  <div 
    x-show="isOpen"
    
    class="bg-popup flex items-center justify-center md:p-6"
  >
    <div class="search-modal">
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
        class="bg-white rounded-t-lg md:rounded-lg shadow-xl w-full max-w-lg mx-auto h-full overflow-hidden"
      >
        <div class="h-full overflow-y-auto px-6 pb-6 [scrollbar-gutter:stable]">
          <x-search />
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  ::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 999px;
}
</style>