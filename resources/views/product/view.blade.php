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
        <div class="product_menu md:hidden opacity-0 -translate-y-full">
            <div class="container flex justify-between">
                <div class="flex gap-4">
                    <div class="relative w-auto">
                        <img src="{{ $product->image }}" alt="{{ $product->title }}">
                        
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
                            <x-badge x-bind:class="(estado === 'Cerrado' ? 'closed' : (estado === 'Abierto' ? 'open' : ''))">
                                <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
                            </x-badge>
                        </div>

                    </div>
                    <div class="content-center">
                        <h2>{{ $product->title }}</h2>
                    </div>
                </div>
                <!-- <div class="product_header_texts">
                </div> -->
                
                <x-contact-icons class="contact-icons" :icons="$product->contacts"></x-contact-icons>
            </div>
        </div>
        <!-- FIN MENU CON IMAGEN, TITLE, BAGDE ABI/CER, CONTACT -->
        <!-- INICIO HOJA PRODUCTO -->
        <div class="product">
            <!-- INICIO BREADCRUMBS -->
            <div class="breadcrumbs">
                <div class="container flex gap-2">
                    <a href="/">
                        <x-icons.home class="fill-gray_400" />
                    </a>
                    <p>/</p>
                    <a href="/categorias">
                        <p class="hidden md:block">Categorías</p>
                        <p class="md:hidden">...</p>
                    </a>
                    <p>/</p>
                    <x-button href="{{route ('categories.view', [ 'category' => $category->slug])}}" class="bg-none">
                        <p>{{ $category->name }}</p>
                    </x-button>
                    <p>/</p>
                    <h2 class="text-small">{{ $subcategory->name }}</h2>
                </div>
            </div>
            <!-- FIN BREADCRUMBS -->
            <!-- INICIO PRIMERA FILA -->
            <div class="flex flex-col lg:flex-row gap-8 container">
                <!-- INICIO SF PRIMERA COLUMNA -->
                <div class="product_header flex-1">
                    <img src="{{ $product->image }}" alt="{{ $product->title }}">
                    <!-- INICIO CATEGORÍAS Y NOMBRE -->
                    <div>
                        <!-- INICIO CATEGORÍAS -->
                        <div class="contenedor_overflow">
                            <div class="contendor_overflow_hijo">
                                @foreach ($product->categories as $category)
                                <div class="flex items-center gap-1 mx-auto md:mx-0">
                                    <div class="w-6 h-6 flex wrap justify-center items-center">
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="cat_image">
                                    </div>
                                    <div><h6>{{ $category->name }}</h6></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- FIN CATEGORÍAS -->
                        <!-- INICIO TITLE -->
                        <div class="text-center lg:text-left">
                            <h2>{{ $product->title }}</h2>
                        </div>
                        <!-- FIN TITLE -->
                    </div>
                    <!-- INICIO CATEGORÍAS Y NOMBRE -->
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
                    <div x-data="verificarEstado({{ json_encode($horarios) }})">
                        <x-badge x-bind:class="(estado === 'Cerrado' ? 'closed' : (estado === 'Abierto' ? 'open' : ''))">
                            <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
                        </x-badge>
                    </div>
                    <!-- FIN BADGE ABIERTO / CERRADO -->
                    <!-- INICIO SHORT DESCRIPTION -->
                    @if ($product->short_description)
                    <div class="product_short_description md:col-span-2">
                        <p class="text-center md:text-left text-gray_500">{{ $product->short_description}}</p>
                    </div>
                    @endif
                    <!-- FIN SHORT DESCRIPTION -->
                    <!-- INICIO VÍAS DE CONTACTO -->
                    <div class="flex flex-col items-center md:items-start gap-4">
                        <x-contact-icons class="contact-icons" :icons="$product->contacts"></x-contact-icons>
                    </div>
                    <!-- FIN VÍAS DE CONTACTO -->
                    <!-- INICIO ADDRESSES -->
                    @if ($product->addresses->isNotEmpty())
                    <div class="product_location">
                        <x-addresses :addresses="$product->addresses"></x-addresses>
                    </div>
                    @endif
                    <!-- FIN ADDRESSES -->
                </div>
                <!-- FIN SF PRIMERA COLUMNA -->
                <!-- INICIO SF SEGUNDA COLUMNA -->
                <div class="product_body">
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="flex gap-1 p-4 border-b-2 rounded-t-lg" id="descripcion-tab" data-tabs-target="#descripcion" type="button" role="tab" aria-controls="descripcion" aria-selected="false">Descripción</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="flex gap-1 p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="horarios-tab" data-tabs-target="#horarios" type="button" role="tab" aria-controls="horarios" aria-selected="false">Horarios</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="flex gap-1 p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="reviews-tab" data-tabs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                    </div>
                    <div id="default-tab-content">
                        @if ($product->description)
                        <div class="hidden text-gray-500" id="descripcion" role="tabpanel" aria-labelledby="descripcion-tab">
                            <div class="p-4 rounded-lg bg-gray-50 w-full lg:w-fit">
                                {!! $product->description !!}
                            </div>
                            <ul class="list-disc p-8">
                                @foreach ($product->listitems as $listitem)
                                <li class="mb-2"><p>{{ $listitem->item}}</p></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if ($product->horarios->isNotEmpty())
                        <div class="hidden text-gray-500" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                            <div class="p-4 rounded-lg bg-gray-50 w-full lg:w-fit">
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
                                    <x-badge x-bind:class="(estado === 'Cerrado' ? 'closed' : (estado === 'Abierto' ? 'open' : ''))">
                                        <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
                                    </x-badge>
                                </div>
                                <!-- FIN BADGE ABIERTO / CERRADO -->
                            </div>
                            <ul class="list-disc p-8">
                            @foreach ($product->horarios as $horario)
                                <li class="mb-2">
                                    <p class="text-gray-500 capitalize">
                                        {{ $horario->dia }} {{ $horario->apertura }} - {{ $horario->cierre }}
                                    </p>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        @endif
                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 w-full lg:w-fit flex justify-center lg:justify-start items-center" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <p class="text-gray-500 text-center lg:text-left">Este anunciante todavía no tiene reviews. Sé el primero!</p>
                        </div>
                    </div>



                    <div>
                        
                        @if ($product->images->count() > 1)
                        <div class="product_gallery">
                            <!-- <h5>Galería de imágenes</h5> -->
                            <x-image-gallery :images="$product->images"></x-image-gallery>
                        </div>
                        @endif
                        @if ($product->addresses->isNotEmpty())
                        <div class="product_map">
                            @foreach ($product->addresses as $address)
                                {!! $address->google_maps !!}
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="grid grid-col-1 md:grid-cols-2 gap-4">
                            
                            
                        </div>
                    </div>
                </div>
                <!-- FIN SF PRIMERA COLUMNA -->
            </div>
            <!-- INICIO PRIMERA FILA -->
        </div>
        <!-- FIN HOJA PRODUCTO -->
    </div>
</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll('[role="tab"]');

        tabButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Limpiar clases de todos los tabs
                tabButtons.forEach((btn) => {
                    btn.classList.remove(
                        "text-primary", "border-primary",
                        "hover:text-primary", "hover:border-primary",
                        "text-blue-600", "border-blue-600",
                        "hover:text-blue-600", "hover:border-blue-600",
                        "hover:text-gray-600", "hover:border-gray-300"
                    );
                    btn.classList.add("text-gray-500", "border-transparent", "hover:text-gray-600", "hover:border-gray-300");
                });

                // Activar el tab clickeado con estilos primary (también en hover)
                button.classList.remove("text-gray-500", "border-transparent", "hover:text-gray-600", "hover:border-gray-300");
                button.classList.add("text-primary", "border-primary", "hover:text-primary", "hover:border-primary");
            });
        });

        // Activar el primer tab por defecto
        if (tabButtons.length > 0) {
            tabButtons[0].click();
        }
    });
</script>

