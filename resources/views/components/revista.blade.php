<section id="revista">
<div class="gradient"></div>
    <div class="container revista_content flex items-center min-h-[500px]">
        <div class="flex flex-col justify-center mx-10 gap-8 h-full">
            <h3>Descargate la última revista en PDF</h3>
            <p class="font-semibold">Llevá Guía Vocerito a donde vayas y encontrá siempre lo que necesitás</p>
            <div x-data="downloadModal()">
                <x-button 
                    class="btn btn-primary w-fit flex items-center gap-2"
                    @click="open()"
                >
                    Descargar
                </x-button>
                <!-- Overlay -->
                <div
                    x-show="isOpen"
                    x-transition.opacity
                    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40"
                    @click="close()"
                    x-cloak
                ></div>
    
                <!-- Modal container -->
                <div
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @keydown.escape.window="close()"
                    class="absolute inset-0 flex items-center justify-center z-50 p-4"
                    x-cloak
                >
                    <div
                        @click.stop
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-6 flex flex-col max-h-[85vh]"
                    >
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">
                                Material para descargar
                            </h2>
                            <button @click="close()" class="text-gray-400 hover:text-gray-600">
                                ✕
                            </button>
                        </div>
    
                        <!-- Listado scrollable -->
                        <div class="flex flex-col gap-4 justify-between">
                            <template x-for="item in items" :key="item.title">
                                <div class="flex justify-between items-center border-b pb-2">
                                    <span x-text="item.title"></span>
    
                                    <a 
                                        :href="item.url"
                                        download
                                        class="btn btn-sm btn-primary flex items-center gap-2 fill-none"
                                    >
                                        Descargar
                                        <x-icons.download class="w-4 h-4" />
                                    </a>
                                </div>
                            </template>
                        </div>
    
                        <!-- Footer -->
                        <div class="mt-6 text-center text-sm text-gray-500">
                            Selecciona un archivo para comenzar la descarga
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="justify-center">
            <img src="{{asset('storage/common/revista.png')}}" alt="">
        </div>
    </div>
</section>
<script>
function downloadModal() {
    return {
        isOpen: false,
        items: [
            { title: "Marzo 2026", url: "#" },
            { title: "Diciembre 2025", url: "#" },
            { title: "Septiembre 2025", url: "#" },
        ],

        open() {
            this.isOpen = true
            document.body.classList.add('overflow-hidden')
        },
        close() {
            this.isOpen = false
            document.body.classList.remove('overflow-hidden')
        }
    }
}
</script>
