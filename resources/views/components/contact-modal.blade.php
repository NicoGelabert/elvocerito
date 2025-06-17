<div 
  x-data="{ isOpen: false }" 
  x-init="window.addEventListener('open-contact-modal', () => isOpen = true)"
>
  <!-- Fondo + x-show controla todo -->
  <div 
    x-show="isOpen"
    
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end md:items-center justify-center md:p-6"
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
      class="bg-white px-6 pt-6 pb-12 rounded-t-lg shadow-xl max-w-screen-sm w-full h-auto overflow-auto"
    >
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-bold">Contacta a {{ $product->title}}</h2>
            <button @click="isOpen = false" class="font-bold">✖</button>
        </div>
        <!-- INICIO VÍAS DE CONTACTO -->
        <x-contact-icons class="contact-icons w-full lg:w-auto" :icons="$product->contacts"></x-contact-icons>
        <!-- FIN VÍAS DE CONTACTO -->      
    </div>
  </div>
</div>
