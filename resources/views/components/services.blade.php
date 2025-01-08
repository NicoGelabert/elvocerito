<div class="flex flex-col gap-16" id="services">
    <div class="flex flex-col md:flex-row w-full justify-between md:gap-16">
        <div class="flex justify-between items-start md:hidden">
            <div class="mb-8">
                <h2 class="text-center">Servicios</h2>
            </div>
            <i class="fi fi-br-arrow-up-left -rotate-90 text-4xl overflow-hidden"></i>
        </div>
        <div class="splide w-full md:w-11/12" id="home-services">
            <div class="splide__track w-full md:px-0  items-start">
                <ul class="splide__list items-start">
                    @foreach ($services as $service)
                        <li class="card splide__slide mx-auto">
                            <div class="imgBx" style="background-image:url({{ $service->image }})">
                                <span class="price"><h4>0{{ $service->id }}</h4></span>
                            </div>
                            <div class="content">
                                <div class="card-title">
                                    <h5>{{ $service->name }}</h5>
                                    <a href="{{ route('service.view', $service->slug) }}"><i class="fi fi-sr-add"></i></a>
                                </div>
                                <div>
                                    <p>{!! $service->short_description !!}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="hidden md:flex flex-col justify-between">
            <div class="h-fit vertical-text ">
                <h2 class="text-center">Servicios</h2>
            </div>
            <i class="fi fi-br-arrow-up-left text-4xl overflow-hidden"></i>
        </div>
    </div>
    <div class="flex justify-end">
        <h2 class="text-right text-7xl big-text">Diseñamos utilizando<br>inteligencia artesanal.</h2>
    </div>
</div>