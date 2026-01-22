<div class="search_hero" style="background-image:url('{{ asset('storage/common/hero-banner.jpg') }}')">
    <!-- <x-backgrounds.pinmaps /> -->
    <div class="container flex flex-col md:flex-row items-center gap-24 md:gap-4">
        <div class="md:w-1/2 flex flex-col mx-auto gap-8">
            <div class="search_hero_container">
                <h1>Servicios cerca tuyo.</h1>
                <p>Encontrá lo que necesitás fácil y rápido!</p>
                <x-button class="w-full max-w-96" onclick="window.dispatchEvent(new CustomEvent('open-search-modal'))">
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
            <div class="flex items-center justify-around gap-4 lg:hidden">
                <div>
                    <x-button href="/anunciantes?urgencies=true" class="btn btn-urgencies shadow-md"><x-icons.urgencies class="fill-white"/> urgencias</x-button>
                </div>
                <div>
                    <x-button href="/anunciantes?page=1&category=farmacias&on_duty=true" class="btn btn-on-duty shadow-md"><x-icons.on_duty /> farmacias de turno</x-button>
                </div>
            </div>
        </div>
        <x-search-modal />

        <div class="hidden md:block md:w-1/2">
            <iframe width="480" height="270" src="https://www.youtube.com/embed/oAVErbQjTpw?si=lBsv4hxjLGYRxn2h&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="max-w-full">
            </iframe>
        </div>
    </div>
</div>