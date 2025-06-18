<div class="search_hero">
    <x-backgrounds.pinmaps />
    <x-search-modal />
    <div class="max-w-screen-lg w-full flex justify-center lg:justify-end mx-auto">
        <div class="search_hero_container">
            <h1>Encontrá lo que necesitás en Zona Sur</h1>
            <p>Más de 200 empresas y prestadores de servicio cerca!</p>
            <x-button class="w-full lg:w-[32rem] max-w-xl p-4 md:px-8 lg:px-0" onclick="window.dispatchEvent(new CustomEvent('open-search-modal'))">
                <div class="relative">
                    <span class="w-full block bg-white px-3 py-2 border-transparent rounded-full drop-shadow-search_input focus:outline-none focus:ring-0 focus:border-none cursor-pointer text-gray-400 text-left">
                        Buscá una empresa o servicio
                    </span>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <x-icons.search />
                    </div>
                </div>
            </x-button>
        </div>
    </div>
</div>