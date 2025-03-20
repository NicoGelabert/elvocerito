@php
    use Carbon\Carbon;
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
        <div class="product">
            <div class="product_view_header">
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

            <div class="flex gap-8 container">
                <div class="w-1/4"></div>
                <div class="mb-10 w-full lg:w-3/4">
                    <h2>{{ $product->title }}</h2>
                </div>
            </div>
            <div class="flex gap-8 container">
                <div class="w-1/4 flex flex-col gap-6">
                    <div class="product_tags">
                        @if ($product->tags->isNotEmpty())
                        <h5>Etiquetas</h5>
                        <div class="tags">
                            @foreach($product->tags as $tag)
                            <x-badge badge_title="{{ $tag->name }}" />
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @if ($product->horarios->isNotEmpty())
                    <div class="product_opening_hours md:col-span-1">
                        <h5>Horario de atención</h5>
                        <div class="product_opening_hours_content">
                            <div class="flex flex-col gap-3">
                            @foreach ($product->horarios as $horario)
                                @php
                                    $apertura = Carbon::parse($horario->apertura)->format('H:i');
                                    $cierre = Carbon::parse($horario->cierre)->format('H:i');
                                @endphp
                                <div class="flex gap-2 items-center"
                                    x-data="verificarHorario('{{ strtolower($horario->dia) }}', '{{ $apertura }}', '{{ $cierre }}')">
                                    <x-badge x-bind:class="(estado === 'Cerrado' ? 'closed' : (estado === 'Abierto' ? 'open' : ''))">
                                        <span x-text="estado"></span> <!-- Pasamos estado como contenido del slot -->
                                    </x-badge>
                                    <p>{{ ucfirst($horario->dia) }} {{ $apertura }} a {{ $cierre }}</p>
                                </div>
                            @endforeach
                            </div>
                            <x-icons.chevron-down />
                        </div>
                    </div>
                    @endif
                    <div class="product_rating md:col-span-1">
                        <div>
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
                    @if ($product->addresses->isNotEmpty())
                    <div class="product_location">
                        <h5>Ubicación</h5>
                        <x-addresses :addresses="$product->addresses"></x-addresses>
                    </div>
                    @endif
                    @if ($product->socials->isNotEmpty())
                    <div class="product_rrss md:col-span-1">
                        <h5>Redes</h5>
                        <div class="product_rating_content">
                            <x-product-social-icons class="product-social-icons" :icons="$product->socials"></x-product-social-icons>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- Inicio Columna derecha -->
                <div class="w-3/4 flex flex-col gap-10">
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
                <!-- Fin Columna derecha -->
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>