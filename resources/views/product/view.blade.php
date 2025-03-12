@php
    
    $bgImage = asset('storage/common/impermeabilizacion_de_techos.png');
    $badge_title = "cerrado";
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
            
            <div class="relative w-auto">
                <img src="{{ $product->image }}" alt="{{ $product->title }}">
                <x-badge :class="($badge_title === 'cerrado' ? 'closed' : ($badge_title === 'abierto' ? 'open' : ''))" badge_title="{{ $badge_title }}" />
            </div>
            <div class="content-center w-[50%]">
                <h2>{{ $product->title }}</h2>
            </div>
            <!-- <div class="product_header_texts">
            </div> -->
            
            <x-contact-icons class="contact-icons w-[34%]" :icons="$product->contacts"></x-contact-icons>
        </div>
        <div class="product container">
            <div class="product_header">
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
                            <x-badge :class="($badge_title === 'cerrado' ? 'closed' : ($badge_title === 'abierto' ? 'open' : ''))"
                            badge_title="{{ $badge_title }}" />
                        </div>
                        <h2>{{ $product->title }}</h2>
                    </div>
                    <x-contact-icons class="contact-icons" :icons="$product->contacts"></x-contact-icons>
                </div>
            </div>
            <div class="product_body">
                <div class="product_tags">
                    <h5>Tags</h5>
                    <div class="tags">
                        @if ($product->tags)
                            @foreach($product->tags as $tag)
                            <x-badge badge_title="{{ $tag->name }}" />
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="product_short_description md:col-span-2">
                        <p class="text-large">{{ $product->short_description}}</p>
                    </div>
                    <div class="product_opening_hours md:col-span-1">
                        <h5>Horario de atención</h5>
                        <div class="product_opening_hours_content">
                            <x-badge :class="($badge_title === 'cerrado' ? 'closed' : ($badge_title === 'abierto' ? 'open' : ''))" badge_title="{{ $badge_title }}" />
                            <p>Jueves 9 a 18hs</p>
                            <x-icons.chevron-down />
                        </div>
                    </div>
                </div>
                <div class="product_description">
                    {!! $product->description !!}
                </div>
                <div class="product_map">
                    <h5>Ubicación</h5>
                    <x-addresses :addresses="$product->addresses"></x-addresses>
                </div>
                <div class="grid grid-col-1 md:grid-cols-2 gap-4">
                    <div class="product_rating md:col-span-1">
                        <h5>Reseñas</h5>
                        <div class="product_rating_content">
                            <x-icons.star class="fill-amber-500"/>
                            <p class="font-bold">4.7</p>
                            <p class="font-bold">Excelente</p>
                            <p>5 Opiniones</p>
                            <x-icons.chevron-down />
                        </div>
                    </div>
                    <div class="product_rrss md:col-span-1">
                        <h5>Redes</h5>
                        <div class="product_rating_content">
                            <x-product-social-icons class="product-social-icons" :icons="$product->socials"></x-product-social-icons>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>