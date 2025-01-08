<?php
    /** @var \Illuminate\Database\Eloquent\Collection $products */
    ?>
    <x-app-demo>
        <div class="bg-demo_white dark:bg-black">
            <div class="flex flex-col justify-around md:flex-row items-center relative max-w-screen-xl mx-auto py-24">
                <div class="w-full md:w-3/5 relative isolate px-6 pb-3 md:pt-0 md:pb-0 lg:px-8 slide-in-left">
                    <div class="flex mb-4 justify-start">
                        <div class="relative rounded-full sm:px-3 py-1 text-xs lg:text-sm leading-6 text-gray-600 sm:ring-1 ring-gray-900/10 hover:ring-gray-900/20 dark:text-gray-600 dark:ring-gray-600">
                        {{__('Site design and developed by')}} Nicolás Gelabert 
                            <a href="/" class="font-semibold">
                                <span class="absolute inset-0" aria-hidden="true"></span>{{__('Back to CV')}} <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                    <div class="text-left">
                        <h1 class="text-4xl font-bold tracking-tight text-demo_primary sm:text-6xl">E-Commerce demo</h1>
                        <p class="mt-2 text-lg leading-8 text-gray-600">{{__('E-commerce site developed with Laravel, Vue JS and Tailwind.')}}</p>
                        <div class="flex gap-3 my-6 md:justify-start">
                            <div class="">
                                <button
                                    class="btn-primary w-full"
                                >
                                {{ __('Login')}}
                                </button>
                            </div>
                            <div class="">
                                <a href="{{ route('register') }}" class="anchor-btn">{{__('Register now')}}<span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-2/5 pr-16 scale-in-center my-6">
                    <img src="{{ asset('storage/images/camera-home.png') }}" alt="" >
                </div>
            </div>
        </div>
        
        <div class="relative mx-2">
            <div class="iconos-entrega">
                <div><x-icono-envio /><span>Envío<br>gratuito</span></div>
                <div><x-icono-pago /><span>Pago<br>seguro</span></div>
                <div><x-icono-devolucion /><span>Devolución<br>garantizada</span></div>
            </div>
        </div>
        
        <div id="image-carousel" class="splide my-32 md:mx-16" aria-label="Latest products">
            <div class="mb-16 text-center">
                <h2 class="font-bold text-3xl">{{__('Latest products')}}
            </div>
            <div class="splide__track mx-8">
                <ul class="splide__list">
                    @foreach($products as $product)
                    <li class="splide__slide border-transparent overflow-hidden rounded-lg bg-white">
                        <a href="{{ route('product.view', [$product->categories->first()->slug, $product->slug]) }}"
                        class="aspect-w-3 aspect-h-2 block">
                            @foreach ($product->alergens as $alergen)
                            <div class="
                            {{ $alergen->name === 'Analógica' ? 'bg-demo_secondary_soft text-demo_secondary' : 'bg-demo_primary_soft text-demo_primary' }}
                            text-xs w-fit rounded-full px-2 py-1 absolute z-10 top-4 left-4">
                                <p class="text-sm">{{$alergen->name}}</p>
                            </div>
                            @endforeach
                            <img src="{{ $product->image }}" alt="{{$product->title}}"
                            class="card-image object-cover hover:scale-105 hover:rotate-1 transition-transform">
                            <div class="flex flex-col p-4 gap-2">
                                @foreach ($product->prices as $price)
                                <p class="font-bold text-sm">${{$price->number}}</p>
                                @endforeach
                                <h6 class="underline-hover w-fit">
                                    {{$product->title}}
                                </h6>
                                @foreach ($product->categories as $category)
                                <p class="font-bold text-xs">{{$category->name}}</p>
                                @endforeach
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <x-promo-welcome />
        
        
    </x-app-demo>