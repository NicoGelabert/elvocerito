<x-app-layout>
<div class="flex flex-col items-center justify-center">
    <!-- <img src="{{ url($service->image) }}" alt=""> -->
    
        <div class="flex flex-col justify-center md:items-stretch gap-12 max-w-screen-xl px-4 pt-24 mx-auto md:px-16 md:flex-row overflow-hidden">
            <div class="flex flex-col justify-start gap-8 w-full md:w-1/2">
                <hr class="animate-hr border-t-2 border-black" />
                <div class="flex justify-between">
                    <h3 class="animate-h3">0{{ $service->id }}</h3>
                    <i class="fi fi-br-arrow-up-left text-4xl animate-arrow overflow-hidden"></i>
                </div>
                <h1 class="animate-h1 text-6xl leading-tight dark:text-primary">{{ $service->title }}</h1>
                <p class="animate-p">{{ $service->description }}</p>
                <div class="flex gap-4 justify-start flex-wrap">
                    
                <!-- for each services -->
                    <div class="animate-button my-2">
                        <x-button href="">
                            <i class="fi fi-rr-arrow-right arrow-to-right"></i>
                            <span></span>
                        </x-button>
                    </div>
                    
                </div>
            </div>
            
            <div class="flex w-full md:w-1/2 h-auto overflow-hidden">
                <ul class="flex flex-col gap-2">
                    @foreach($service->attributes as $attribute)
                    <div class="w-full p-4 flex justify-start gap-4 items-start animate-service-item">
                    <i class="fi fi-sr-comment-alt-check"></i><li class="text-sm">{{ $attribute->text }}</li>
                    </div>
                    @endforeach
                </ul>
            </div>
        </div>
        

        <hr class="divider w-full" />

        <!-- <div x-data="{ 
            isOpen: false, 
            currentImage: '', 
            currentTitle: '', 
            currentClient: '', 
            currentServiceItems: [] 
        }" class="w-full">
            <div id="service_gallery" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($service_portfolios as $service_portfolio)
                        <li class="splide__slide" 
                            @click="isOpen = true; 
                                    currentImage = '{{ url($service_portfolio->image) }}'; 
                                    currentTitle = '{{ $service_portfolio->title }}'; 
                                    currentClient = '{{ $service_portfolio->client->title }}'; 
                                    currentServiceItems = {{ $service_portfolio->serviceItems->toJson() }}">
                            <div class="h-[300px] w-[300px]">
                                <img src="{{ url($service_portfolio->image) }}" class="h-full w-full object-cover" alt="{{ $service_portfolio->title }}">
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div x-show="isOpen" @click.away="isOpen = false" class="fixed inset-0 flex justify-center bg-black bg-opacity-75 z-50 overflow-auto">
                <div class="mx-8 my-8 lg:my-auto lg:flex lg:flex-row lg:gap-8 lg:items-start lg:max-h-1/2 lg:max-w-screen-xl">
                    <button @click="isOpen = false" class="absolute top-0 right-0 m-4 text-white text-xl">&times;</button>
                    <div class="lg:w-1/2">
                        <img :src="currentImage" class="lg:max-w-lg max-h-[80vh]">
                    </div>
                    <div class="text-white lg:w-1/2 py-8 flex flex-col gap-8">
                        <h3 x-text="currentTitle"></h3>
                        <div>
                            <h6>Cliente</h6>
                            <p x-text="currentClient"></p>
                        </div>
                        <div>
                            <ul class="flex gap-2 flex-wrap">
                                <template x-for="item in currentServiceItems" :key="item.id">
                                    <li x-text="item.title" class="mt-1 bg-gray-50 text-xs w-fit rounded-full px-4 py-2 text-black"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
        <hr class="divider w-full" />
        
        <x-quotation :tags="$groupedTags" />
</div>

</x-app-layout>
<script>
    function animateElement(element, delay) {
    setTimeout(() => {
      element.classList.add('active');
    }, delay);
  }

  
    var hr = document.querySelector('.animate-hr');
    var h3 = document.querySelector('.animate-h3');
    var h1 = document.querySelector('.animate-h1');
    var p = document.querySelector('.animate-p');
    var arrow = document.querySelector('.animate-arrow');
    var serviceItems = document.querySelectorAll('.animate-service-item');
    var buttons = document.querySelectorAll('.animate-button');

    animateElement(hr, 200); // 0.2 segundos después
    animateElement(h3, 500); // 0.5 segundos después
    animateElement(h1, 750); // 0.75 segundos después
    animateElement(p, 1000); // 1 segundo después
    animateElement(arrow, 1250); // 2.5 segundos después (flecha)
    // Animar secuencialmente los items del servicio
    serviceItems.forEach((item, index) => {
        animateElement(item, 1500 + index * 250); // 1.5 segundos + 0.25 segundos por cada item
    });
    buttons.forEach((item, index) => {
        animateElement(item, 2750 + index * 250);
    });

</script>