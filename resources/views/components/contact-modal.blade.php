<meta property="og:title" content="{{ $product->title }}" />
<meta property="og:description" content="{{ $product->short_description }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ $product->image }}" />
<meta name="twitter:card" content="summary_large_image" />

<div 
  x-data="{ isOpen: false, type: null, show:false }" 
  x-init="window.addEventListener('open-contact-modal', e => {
    if (!e.detail.id || e.detail.id === {{ $product->id }}) {
      type = e.detail.type;
      isOpen = true;
    }
})"
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
      class="bg-white px-6 pt-6 pb-12 rounded-t-lg md:rounded-lg shadow-xl max-w-screen-sm w-full h-auto overflow-auto relative"
    >
    <!-- INICIO VÍAS DE CONTACTO -->
      <div x-show="type === 'contact'" x-transition>
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-bold">Contacta a {{ $product->title}}</h2>
            <button @click="isOpen = false" class="font-bold">✖</button>
        </div>
        <x-contact-icons class="contact-icons w-full lg:w-auto" :icons="$product->contacts"></x-contact-icons>
      </div>
      <!-- FIN VÍAS DE CONTACTO -->
      <div 
        x-show="show" 
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="opacity-0 translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full"
        x-init="$watch('show', value => value && setTimeout(() => show = false, 2000))"
        class="absolute w-max bottom-28 right-1/2 translate-x-1/2 bg-gray-800 text-white text-sm px-4 py-2 rounded shadow z-50"
        style="display: none;"
        x-ref="toast"
      >
        Enlace copiado al portapapeles
      </div>
      <template x-if="type === 'share'">

        <!-- INICIO REDES SOCIALES -->
        <div class="flex flex-col gap-8 bg-white rounded-xl p-4">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold">Compartí a {{ $product->title}}</h2>
            <button @click="isOpen = false" class="font-bold">✖</button>
          </div> 

          <div class="flex flex-col items-center md:flex-row md:items-start gap-4">
            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="rounded-lg w-full max-w-24 h-auto object-cover">
            <div class="flex flex-col gap-4 items-center md:items-start">
              <div class="flex items-center flex-col md:flex-row md:items-start gap-2 mx-auto md:mx-0">
                @foreach ($product->categories as $category)
                <div class="flex gap-1">
                  <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-3 h-3 rounded-none m-0">
                  <h6>{{ $category->name }}</h6>
                </div>
                @endforeach
              </div>
              <h4>{{ $product->title }}</h4>
              <p class="text-center md:text-left">{{ $product->short_description }}</p>
            </div>
          </div>

          @php
              $shareUrl = urlencode(url()->current());
              $shareText = urlencode($product->title . ' - ' . $product->short_description);
          @endphp

          <div class="flex justify-center gap-4">
              <a class="bg-gray-100 p-2 rounded-md" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank">
                  <x-icons.facebook class="w-5 h-5 fill-secondary" />
              </a>
              <a class="bg-gray-100 p-2 rounded-md" href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank">
                  <x-icons.whatsapp class="w-5 h-5 fill-secondary" />
              </a>
              <a class="bg-gray-100 p-2 rounded-md" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank">
                  <x-icons.linkedin class="w-5 h-5 fill-secondary" />
              </a>
              <!-- Copiar enlace -->
              <x-button 
                @click="
                  navigator.clipboard.writeText('{{ $shareUrl }}').then(() => {
                    $refs.toast.show = true;
                    show = true;
                  })
                "
                class="bg-gray-100 p-2 rounded-md hover:bg-gray-200" 
                title="Copiar enlace"
              >
                <x-icons.copy class="w-5 h-5 text-secondary" />
              </x-button>
          </div>
        </div>

        <!-- FIN REDES SOCIALES -->
      </template>
    </div>
  </div>
</div>