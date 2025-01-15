<div class="flex flex-col md:flex-row" id="portfolio">
    <div class="w-full md:w-1/3 h-auto flex flex-col justify-between">
        <div class="w-full flex justify-between pr-4">
            <div class="h-fit hidden md:block vertical-text ">
                <h2 class="text-center">Portfolio</h2>
            </div>
            <div class="h-fit md:hidden">
                <h2 class="text-center">Portfolio</h2>
            </div>
            <div class="h-fit -rotate-90">
                <i class="fi fi-br-arrow-up-left text-4xl overflow-hidden"></i>
            </div>
        </div>
        <div class="hidden md:flex">
            <p class="text-2xl">Una ventana a nuestro mundo creativo</p>
        </div>
    </div>
    <div class="relative w-full md:w-2/3">
        <div id="main-carousel" class="h-full flex flex-col md:flex-row splide mx-auto" aria-label="Portfolio">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($projects as $project)
                    <li class="splide__slide flex flex-col-reverse md:flex-row">
                        <div class="h-full w-full md:w-1/2 flex justify-center items-center md:items-start mb-16">
                            <img src="{{ $project->image }}" alt="{{ $project->name }}">
                        </div>
                        <div class="w-full md:w-1/2 md:max-h-[50%] py-8 md:p-4 flex flex-col gap-4">
                            <div>
                                <div class="flex justify-between">
                                    <h5>{{ $project->title }}</h5>
                                    <h4 class="text-gray_200 ml-4">{{ $project->id }}/15</h4>
                                </div>
                                <ul>
                                    @foreach($project->clients as $client)
                                    <li class="text-sm">{{ $client->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <ul class="hidden md:flex flex-wrap gap-2">
                                @foreach($project->tags as $tag)
                                <li class="mt-1 bg-gray-50 text-xs w-fit rounded-full px-2 py-1 text-black dark:bg-gray_800 dark:text-white">{{ $tag->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div id="thumbnail-carousel" class="reltive md:absolute bottom-0 right-0 w-full md:w-1/2 mt-4 md:mt-0 md:py-12 hidden md:flex items-center px-4 splide" aria-label="Puede ver todos nuestros trabajos.">
            <div class="splide__track">
                <div class="splide__list">
                    @foreach($projects as $project)
                        <li class="splide__slide">
                            <div>
                                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="aspect-square bg-cover">
                            </div>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>