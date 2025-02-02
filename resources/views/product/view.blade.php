@php
    $contactIcons = [
        ['icon' => 'phone', 'name' => 'Teléfono', 'text' => '+54 11 1234-5678', 'active' => true],
        ['icon' => 'mobile', 'name' => 'Teléfono Móvil', 'text' => '+54 9 11 9876-5432', 'active' => true],
        ['icon' => 'whatsapp', 'name' => 'WhatsApp', 'text' => '+54 9 11 1234-5678', 'active' => true],
        ['icon' => 'email', 'name' => 'E-mail', 'text' => 'contacto@empresa.com', 'active' => true],
    ];
    $bgImage = asset('storage/common/impermeabilizacion_de_techos.png');
    $badge_title = "abierto";
@endphp
<x-app-layout>
    <div id="product-view"
        x-data="productItem({{ json_encode([
        'id' => $product->id,
        'slug' => $product->slug,
        'image' => $product->image,
        'title' => $product->title,
        'quantity' => $product->quantity,
        'prices' => $product->prices->map(function ($price) {
            return [
                'number' => $price->number,
                'size' => $price->size,
            ];
        }),
        'images' => $product->images->pluck('url') 
        ]) }})">
        <div class="product_menu opacity-0 -translate-y-full">
            <div class="product_menu_header">
                <div class="relative">
                    <img src="{{ $product->image }}" alt="{{ $product->title }}">
                    <x-badge :class="($badge_title === 'cerrado' ? 'closed' : ($badge_title === 'abierto' ? 'open' : ''))"
                    badge_title="{{ $badge_title }}" />
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->categories as $category)
                        <x-badge badge_title="{{ $category->name }}" />
                        @endforeach
                    </div>
                    <h2>{{ $product->title }}</h2>
                </div>
                <!-- <div class="product_header_texts">
                </div> -->
            </div>
            <x-contact-icons class="contact-icons" :icons="collect($contactIcons)->where('active', true)->toArray()"></x-contact-icons>
        </div>
        <div class="product-view-hero splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <img src="{{ $bgImage }}" alt="">
                    </li>
                </ul>
            </div>
            <div class="bg-layer"></div>
        </div>
        <div class="product container">
            <div class="product_header">
                <img src="{{ $product->image }}" alt="{{ $product->title }}">
                <div class="product_header_texts">
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->categories as $category)
                        <x-badge badge_title="{{ $category->name }}" />
                        @endforeach
                        <x-badge :class="($badge_title === 'cerrado' ? 'closed' : ($badge_title === 'abierto' ? 'open' : ''))"
                        badge_title="{{ $badge_title }}" />
                    </div>
                    <h2>{{ $product->title }}</h2>
                </div>
                <x-contact-icons class="contact-icons" :icons="collect($contactIcons)->where('active', true)->toArray()"></x-contact-icons>
            </div>
            <div class="product_content">
                <div class="text-center">
                    <p class="text-large">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Totam aspernatur earum optio commodi similique modi hic quos incidunt, dolores veniam vel sunt, quia maxime voluptate reprehenderit amet nihil. Similique, maiores!</p>
                </div>
            </div>
            <div class="product_content_description">
                {!! $product->description !!}
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>