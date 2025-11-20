@section('meta')
    <title>{{ $product->title }}, {{ $category->name }}</title>
    <meta name="description" content="{{ $product->short_description }}">
    <meta name="keywords" content="{{ $product->tags->pluck('name')->implode(', ') }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@php
    use Carbon\Carbon;
    $hoy = strtolower(Carbon::now()->locale('es')->isoFormat('dddd')); // Día de hoy en minúsculas
    $horarios = $product->horarios->sortBy(fn($h) => array_search(strtolower($h->dia), [
        "lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"
    ]));

    // Buscar el horario de hoy o el siguiente disponible
    $horarioHoy = $horarios->firstWhere('dia', ucfirst($hoy)) ?? $horarios->first();
@endphp
<x-app-layout>
    <div id="product-view"
        x-data="productItem({{ json_encode([
        'id' => $product->id,
        'slug' => $product->slug,
        'image' => $product->image,
        'title' => $product->title,
        'contacts' => $product->contacts,
        'addresses' => $product->addresses,
        'images' => $product->images->pluck('url') 
        ]) }})">
        <!-- INICIO MENU CON IMAGEN, TITLE, BAGDE ABI/CER, CONTACT -->
        <div class="product_menu lg:hidden opacity-0 -translate-y-full">
            <div class="flex items-center justify-between">
                <div class="flex gap-2 items-center">
                    <div class="relative w-auto flex items-center">
                        <img src="{{ $product->image }}" alt="{{ $product->title }}">
                        @if($product->horarios->isNotEmpty())
                        @php
                            $horarios = $product->horarios->map(function($horario) {
                                return [
                                    'dia' => $horario->dia,
                                    'apertura' => Carbon::parse($horario->apertura)->format('H:i'),
                                    'cierre' => Carbon::parse($horario->cierre)->format('H:i')
                                ];
                            });
                        @endphp
                        <div x-data="verificarEstado({{ json_encode($horarios) }})">
                            <x-badge x-bind:class="(estado === 'No Disponible' ? 'closed' : (estado === 'Disponible' ? 'open' : ''))">
                                <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
                            </x-badge>
                        </div>
                        @endif
                    </div>
                    <div class="content-center overflow-hidden line-clamp-1 h-fit">
                        <h2>{{ $product->title }}</h2>
                    </div>
                </div>
                <!-- <div class="product_header_texts">
                </div> -->
                
                <div class="flex gap-4">
                    <!-- INICIO VÍAS DE CONTACTO -->
                    <x-button class="btn btn-secondary" onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                    detail: { type: 'contact' }
                    }))">
                        Contactar
                    </x-button>
                    <!-- FIN VÍAS DE CONTACTO -->
                    <!-- INICIO VÍAS DE COMPARTIR -->
                    <x-button class="btn btn-secondary" onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                    detail: { type: 'share' }
                    }))">
                        <x-icons.share class="fill-primary" />
                    </x-button>
                    <!-- FIN VÍAS DE COMPARTIR -->
                </div>
            </div>
        </div>
        <!-- FIN MENU CON IMAGEN, TITLE, BAGDE ABI/CER, CONTACT -->
        <!-- INICIO HOJA PRODUCTO -->
        <div class="product">
            <!-- INICIO BREADCRUMBS -->
            <div class="breadcrumbs">
                <div class="container flex gap-2 items-center">
                    <a href="/">
                        <x-icons.home class="fill-gray_400" />
                    </a>
                    <p>/</p>
                    <a href="/anunciantes">
                        <p class="hidden md:block">Categorías</p>
                        <p class="md:hidden">...</p>
                    </a>
                    <p>/</p>
                    <x-button href="{{route ('categories.view', [ 'category' => $category->slug])}}" class="bg-none">
                        <p>{{ $category->name }}</p>
                    </x-button>
                </div>
            </div>
            <!-- FIN BREADCRUMBS -->
            <!-- INICIO PRIMERA FILA -->
            <div class="container">
                <x-contact-modal :product="$product" />
                
                <div class="flex flex-col lg:flex-row gap-6  bg-white rounded-xl p-4">
                    <!-- INICIO PRIMERA COLUMNA -->
                    <div class="product_header custom-scrollbar lg:overflow-x-hidden flex-1">
                        <img src="{{ $product->image }}" alt="{{ $product->title }}">
                        <!-- INICIO CONTENEDOR PRODUCT HEADER SIN IMAGEN -->
                        <div class="flex flex-col lg:pr-4 lg:pl-2 gap-4">
                            <!-- INICIO CATEGORÍAS Y NOMBRE -->
                            <div class="flex flex-col gap-4">
                                <!-- INICIO CATEGORÍAS -->
                                <div class="contenedor_overflow">
                                    <div class="contenedor_overflow_hijo">
                                        @foreach ($product->categories as $category)
                                        <div class="flex items-center mx-auto md:mx-0">
                                            <div class="w-6 h-6 flex wrap items-center">
                                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="cat_image">
                                            </div>
                                            <div>
                                                <h6>{{ $category->name }}</h6>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- FIN CATEGORÍAS -->
                                <!-- INICIO TITLE -->
                                <h2>{{ $product->title }}</h2>
                                <!-- Promedio de calificaciones -->
                                <div class="product-rating-average product_rating" data-product-id="{{ $product->id }}"></div>
                                <!-- FIN TITLE -->
                                <!-- INICIO PÁGINA WEB -->
                                @if ($product->webs->isNotEmpty())
                                <div class="webpage">
                                    @foreach ($product->webs as $web)
                                    @php
                                        $url = $web->webpage;
                                        
                                        // Para el href: agregar https:// si no está
                                        $link = Str::startsWith($url, ['http://', 'https://']) ? $url : 'https://' . $url;
         
                                        // Para el texto: eliminar protocolo y barra final
                                        $display = preg_replace('/^https?:\/\//', '', $url);         // quita http:// o https://
                                        $display = preg_replace('/^www\./', '', $display);           // Quita www. si existe al principio
                                        $display = rtrim($display, '/');                             // quita barra final si existe
                                    @endphp
                                    <a href="{{ $link }}" class="flex gap-2 items-center" target="blank">
                                        <p>{{ $display }}</p>
                                        <x-icons.external-link />
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                                <!-- FIN PÁGINA WEB -->
                                </div>
                             <!-- FIN CATEGORÍAS Y NOMBRE -->
                             <!-- INICIO BADGE ABIERTO / CERRADO, SHORT DESCRIPTION, VÍAS DE CONTACTO Y ADDRESSES -->
                             <div class="flex flex-col gap-6 items-center md:items-start">
                                 <!-- INICIO BADGE ABIERTO / CERRADO -->
                                @if($product->horarios->isNotEmpty())
                                @php
                                    $horarios = $product->horarios->map(function($horario) {
                                        return [
                                            'dia' => $horario->dia,
                                            'apertura' => Carbon::parse($horario->apertura)->format('H:i'),
                                            'cierre' => Carbon::parse($horario->cierre)->format('H:i')
                                        ];
                                    });
                                @endphp
                                <div x-data="verificarEstado({{ json_encode($horarios) }})">
                                    <x-badge x-bind:class="(estado === 'No Disponible' ? 'closed' : (estado === 'Disponible' ? 'open' : ''))">
                                        <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
                                    </x-badge>
                                </div>
                                @endif
                                <!-- FIN BADGE ABIERTO / CERRADO -->
                                <!-- INICIO SHORT DESCRIPTION -->
                                @if ($product->short_description)
                                <div class="product_short_description md:col-span-2">
                                    <p class="text-center md:text-left text-gray_500">{{ $product->short_description}}</p>
                                </div>
                                @endif
                                <!-- FIN SHORT DESCRIPTION -->
                                <div class="flex gap-4">
                                    <!-- INICIO VÍAS DE CONTACTO -->
                                    <x-button class="btn btn-secondary" onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                    detail: { type: 'contact' }
                                    }))">
                                        Contactar
                                    </x-button>
                                    <!-- FIN VÍAS DE CONTACTO -->
                                    <!-- INICIO VÍAS DE COMPARTIR -->
                                    <x-button class="btn btn-secondary" onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                    detail: { type: 'share' }
                                    }))">
                                        <x-icons.share class="fill-primary" />
                                    </x-button>
                                    <!-- FIN VÍAS DE COMPARTIR -->
                                </div>
                                <!-- INICIO ADDRESSES -->
                                @if ($product->addresses->isNotEmpty())
                                <div class="product_location">
                                    <x-addresses :addresses="$product->addresses"></x-addresses>
                                </div>
                                @endif
                                <!-- FIN ADDRESSES -->
                            </div>
                            <!-- FIN BADGE ABIERTO / CERRADO, SHORT DESCRIPTION, VÍAS DE CONTACTO Y ADDRESSES -->
                        </div>
                        <!-- FIN CONTENEDOR PRODUCT HEADER SIN IMAGEN -->
                    </div>
                    <!-- FIN PRIMERA COLUMNA -->
                    <!-- INICIO SEGUNDA COLUMNA -->
                    <div class="product_body">
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                @if($product->description)
                                <li class="w-1/3" role="presentation">
                                    <button class="w-full flex gap-1 justify-center p-4 border-b-2 rounded-t-lg" id="descripcion-tab" data-tabs-target="#descripcion" type="button" role="tab" aria-controls="descripcion" aria-selected="false">Descripción</button>
                                </li>
                                @endif
                                @if($product->horarios->isNotEmpty())
                                <li class="w-1/3" role="presentation">
                                    <button class="w-full flex gap-1 justify-center p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="horarios-tab" data-tabs-target="#horarios" type="button" role="tab" aria-controls="horarios" aria-selected="false">Horarios</button>
                                </li>
                                @endif
                                <li class="w-1/3" role="presentation">
                                    <button class="w-full flex gap-1 justify-center p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="reviews-tab" data-tabs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-tab-content">
                            @if ($product->description || $product->listitems || $product->tags || $product->socials)
                            <div class="hidden text-gray-500 flex flex-col gap-8" id="descripcion" role="tabpanel" aria-labelledby="descripcion-tab">
                                <!-- INICIO DESCRIPCIÓN LARGA -->
                                @if($product->description)
                                <div class="p-4 rounded-lg bg-gray-50 w-full lg:w-fit">
                                    {!! $product->description !!}
                                </div>
                                @endif
                                <!-- FIN DESCRIPCIÓN LARGA -->
                                <!-- INICIO ITEMS -->
                                @if($product->listitems->isNotEmpty())
                                <ul class="list-disc px-8">
                                    @foreach ($product->listitems as $listitem)
                                    <li class="mb-2"><p>{{ $listitem->item}}</p></li>
                                    @endforeach
                                </ul>
                                @endif
                                <!-- FIN ITEMS -->
                                <!-- INICIO TAGS -->
                                @if($product->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($product->tags as $tag)
                                    <x-badge badge_title="{{ $tag->name }}"/>
                                    @endforeach
                                </div>
                                @endif
                                <!-- FIN TAGS -->
                                <!-- INICIO REDES SOCIALES -->
                                @if($product->socials->isNotEmpty())
                                <div class="product_rrss">
                                    <h4>Seguí sus redes</h4>
                                    <x-product-social-icons class="product-social-icons" :icons="$product->socials"></x-product-social-icons>
                                </div>
                                @endif
                                <!-- FIN REDES SOCIALES -->
                            </div>
                            @endif
     
                            @if ($product->horarios->isNotEmpty())
                            <div class="hidden text-gray-500" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                                <div class="p-4 rounded-lg bg-gray-50 w-full lg:w-fit mb-4">
                                     <!-- INICIO BADGE ABIERTO / CERRADO -->
                                    @php
                                        $horarios = $product->horarios->map(function($horario) {
                                            return [
                                                'dia' => $horario->dia,
                                                'apertura' => Carbon::parse($horario->apertura)->format('H:i'),
                                                'cierre' => Carbon::parse($horario->cierre)->format('H:i')
                                            ];
                                        });
                                    @endphp
                                    <div x-data="verificarEstado({{ json_encode($horarios) }})" class="rounded-lg bg-gray-50 flex gap-2 justify-center lg:justify-start items-center">
                                        <p>En este momento, se encuentra </p>
                                        <x-badge x-bind:class="(estado === 'No Disponible' ? 'closed' : (estado === 'Disponible' ? 'open' : ''))">
                                            <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
                                        </x-badge>
                                    </div>
                                     <!-- FIN BADGE ABIERTO / CERRADO -->
                                </div>
                                <div class="flex flex-col md:flex-row gap-8 p-8">
                                    <ul class="list-disc">
                                    @foreach ($product->horarios as $horario)
                                        <li class="mb-2">
                                            <p class="text-gray-500 capitalize">
                                                {{ $horario->dia }} {{ $horario->apertura }} - {{ $horario->cierre }}
                                            </p>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="md:w-1/2">
                                        @if ($product->addresses->isNotEmpty())
                                        <div class="product_map">
                                            @foreach ($product->addresses as $address)
                                            {!! $address->google_maps !!}
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 w-full" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div id="product-view-app" class="flex flex-col gap-8">
                                    <!-- Listado de reviews publicadas -->
                                    <review-list :product-id="{{$product->id}}"></review-list>
                                    <!-- Formulario para dejar review -->
                                    <review-form :product-id="{{$product->id}}"></review-form>

                                </div>
                            </div>

                        </div>
                        
                        <div>
                            @if ($product->images->count() > 1)
                            <div class="product_gallery">
                                <!-- <h5>Galería de imágenes</h5> -->
                                <x-image-gallery :images="$product->images" class="product_gallery_images"></x-image-gallery>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- FIN SEGUNDA COLUMNA -->
                </div>
            </div>
            <!-- FIN PRIMERA FILA -->
        </div>
        <!-- FIN HOJA PRODUCTO -->
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const tabButtons = document.querySelectorAll('[role="tab"]');
        const tabContents = document.querySelectorAll('[role="tabpanel"]');

        if (tabButtons.length === 0 || tabContents.length === 0) return;

        tabButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const targetId = button.getAttribute("data-tabs-target");

                // Deactivate all tabs
                tabButtons.forEach((btn) => {
                    btn.setAttribute("aria-selected", "false");
                    btn.classList.remove(
                        "text-primary", "border-primary",
                        "hover:text-primary", "hover:border-primary"
                    );
                    btn.classList.add(
                        "text-gray-500", "border-transparent",
                        "hover:text-gray-600", "hover:border-gray-300"
                    );
                });

                // Hide all contents
                tabContents.forEach((content) => {
                    content.classList.add("hidden");
                });

                // Activate clicked tab
                button.setAttribute("aria-selected", "true");
                button.classList.remove(
                    "text-gray-500", "border-transparent",
                    "hover:text-gray-600", "hover:border-gray-300"
                );
                button.classList.add(
                    "text-primary", "border-primary",
                    "hover:text-primary", "hover:border-primary"
                );

                // Show corresponding tab content
                if (targetId) {
                    const targetContent = document.querySelector(targetId);
                    if (targetContent) {
                        targetContent.classList.remove("hidden");
                    }
                }
            });
        });

        // Click the first tab by default
        tabButtons[0].click();
    });
</script>
