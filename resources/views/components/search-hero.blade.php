<div class="search_hero">
    <!-- <x-backgrounds.pinmaps /> -->
    <div class="flex flex-col mx-auto gap-6 md:gap-8 {{ request()->routeIs('categories.index') ? 'pb-0 max-w-[85%]' : 'pb-36 md:pb-24' }}">
        <div class="search_hero_container">
            <p class="subheading">Hola!</p>
            <h1>Qué necesitás hoy?</h1>
            <x-button class="w-full min-w-[320px]" onclick="window.dispatchEvent(new CustomEvent('open-search-modal'))">
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
        <!-- Botones Urgencias y Farmacias de turno -->
        <div class="flex items-center justify-center gap-4 hidden">
            <div class="">
                <x-button href="/servicios?urgencies=true" class="btn btn-urgencies shadow-md"><x-icons.urgencies class="fill-white"/> urgencias</x-button>
            </div>
            <div>
                <x-button href="/servicios?page=1&category=farmacias&on_duty=true" class="btn btn-on-duty shadow-md"><x-icons.on_duty /> farmacias de turno</x-button>
            </div>
        </div>
    </div>
</div>