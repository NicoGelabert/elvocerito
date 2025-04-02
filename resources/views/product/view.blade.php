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
        <div class="product_menu opacity-0 -translate-y-full">
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
            <div class="flex gap-8 container">
                <!-- INICIO ESPACIO VACIO -->
                <div class="hidden lg:block w-1/4"></div>
                <!-- FIN ESPACIO VACIO -->
                <!-- INICIO TITLE -->
                <div class="mb-10 w-full lg:w-3/4 text-center lg:text-left">
                    <h2>{{ $product->title }}</h2>
                </div>
                <!-- FIN TITLE -->
            </div>
            <!-- FIN PRIMERA FILA -->
            <!-- INICIO SEGUNDA FILA -->
            <div class="flex flex-col lg:flex-row gap-8 container">
                <!-- INICIO SF PRIMERA COLUMNA -->
                <div class="block overflow-x-auto scroll-smooth w-full lg:w-1/4">
                    <!-- INICIO CONTENEDOR HORIZONTAL: MOBILE -->
                    <div class="horizontal_scrolling_container">
                        <!-- INICIO RESEÑAS -->
                        <div class="product_rating md:col-span-1">
                            <div class="hidden lg:block">
                                <h5>Reseñas</h5>
                                <p class="text-gray_400">5 Opiniones</p>
                            </div>
                            <div class="product_rating_content">
                                <x-icons.star class="fill-amber-500"/>
                                <p class="font-bold">4.7</p>
                                <p class="font-bold">Excelente</p>
                                <x-icons.chevron-down />
                            </div>
                        </div>
                        <!-- FIN RESEÑAS -->
                        <!-- INICIO HORARIOS -->
                        @if ($product->horarios->isNotEmpty())
                        <div class="product_opening_hours md:col-span-1">
                            <h5>Horario de atención</h5>
                            <div class="product_opening_hours_content" x-data="{ modalAbierto: false }">
                                <div class="flex flex-col gap-3">
                                    @if ($horarioHoy)
                                        @php
                                            $apertura = Carbon::parse($horarioHoy->apertura)->format('H:i');
                                            $cierre = Carbon::parse($horarioHoy->cierre)->format('H:i');
                                        @endphp
                                        <div class="flex gap-2 items-center lg:px-4"
                                            x-data="verificarHorario('{{ strtolower($horarioHoy->dia) }}', '{{ $apertura }}', '{{ $cierre }}')">
                                            <p>{{ ucfirst($horarioHoy->dia) }} {{ $apertura }} - {{ $cierre }}</p>
                                            <template x-if="esHoy">
                                                <x-badge x-bind:class="(estado === 'Cerrado' ? 'closed' : 'open')">
                                                    <span x-text="estado"></span>
                                                </x-badge>
                                            </template>
                                        </div>
                                    @else
                                        <p>No hay horarios disponibles.</p>
                                    @endif
                                </div>

                                <!-- Botón para abrir modal -->
                                <button @click="modalAbierto = true" class="px-3">
                                    <x-icons.chevron-down />
                                </button>

                                <!-- Modal con todos los horarios -->
                                <div x-show="modalAbierto" class="horario_modal">
                                    <div 
                                        class="horario_modal_content">
                                        <h4 class="lg:hidden">Horario de atención</h4>
                                        <div class="flex items-start justify-between gap-4 relative">
                                            <ul>
                                                @foreach ($product->horarios as $horario)
                                                    <li><p>{{ ucfirst($horario->dia) }} 
                                                        {{ Carbon::parse($horario->apertura)->format('H:i') }} - 
                                                        {{ Carbon::parse($horario->cierre)->format('H:i') }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <button @click="modalAbierto = false">✕</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- FIN HORARIOS -->
                         
                        <!-- INICIO ADDRESSES -->
                        @if ($product->addresses->isNotEmpty())
                        <div class="product_location">
                            <h5>Ubicación</h5>
                            <x-addresses :addresses="$product->addresses"></x-addresses>
                        </div>
                        @endif
                        <!-- FIN ADDRESSES -->
                        <!-- INICIO SOCIALS -->
                        @if ($product->socials->isNotEmpty())
                        <div class="product_rrss md:col-span-1">
                            <h5>Redes</h5>
                            <div class="product_rating_content">
                                <x-product-social-icons class="product-social-icons" :icons="$product->socials"></x-product-social-icons>
                            </div>
                        </div>
                        @endif
                        <!-- FIN SOCIALS -->
                        <!-- INICIO TAGS -->
                        @if ($product->tags->isNotEmpty())
                        <div class="product_tags">
                            <h5>Etiquetas</h5>
                            <div class="tags">
                                @foreach($product->tags as $tag)
                                <x-badge badge_title="{{ $tag->name }}" />
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <!-- FIN TAGS -->
                    </div>
                    <!-- INICIO CONTENEDOR HORIZONTAL: MOBILE -->
                </div>
                <!-- FIN SF PRIMERA COLUMNA -->
                <!-- INICIO SF SEGUNDA COLUMNA -->
                <div class="w-full lg:w-3/4 flex flex-col gap-10">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="product_header flex-1">
                            <img src="{{ $product->image }}" alt="{{ $product->title }}">
                            <div class="flex flex-col items-center md:items-start gap-4">
                                <div class="product_header_texts">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($product->categories as $category)
                                        <x-badge badge_title="{{ $category->name }}" />
                                        @endforeach
                                        <!-- @foreach ($product->contacts as $contact)
                                        <x-badge class="star" badge_title="{{ $contact->number % 1 == 0 ? number_format($contact->number, 0) : number_format($contact->number, 1) }}" />
                                        @endforeach -->
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
                                </div>
                                <x-contact-icons class="contact-icons" :icons="$product->contacts"></x-contact-icons>
                            </div>
                        </div>
                    </div>
                    <div class="product_body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if ($product->short_description)
                            <div class="product_short_description md:col-span-2">
                                <p class="text-large">{{ $product->short_description}}</p>
                            </div>
                            @endif
                        </div>
                        @if ($product->description)
                        <div class="product_description">
                            {!! $product->description !!}
                        </div>
                        @endif
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
            <!-- INICIO SEGUNDA FILA -->
        </div>
        <!-- FIN HOJA PRODUCTO -->
    </div>
</x-app-layout>

<script>

</script>