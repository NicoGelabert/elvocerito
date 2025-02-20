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
        'quantity' => $product->quantity,
        'contacts' => $product->contacts,
        'images' => $product->images->pluck('url') 
        ]) }})">
        <div class="product_menu opacity-0 -translate-y-full">
            <div class="lg:mx-auto lg:max-w-screen-xl flex flex-col md:flex-row gap-4 items-center justify-between lg:w-full">
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
                            <!-- @foreach ($product->contacts as $contact)
                            <x-badge class="star" badge_title="{{ $contact->number % 1 == 0 ? number_format($contact->number, 0) : number_format($contact->number, 1) }}" />
                            @endforeach -->
                        </div>
                        <h2>{{ $product->title }}</h2>
                    </div>
                    <!-- <div class="product_header_texts">
                    </div> -->
                </div>
                <x-contact-icons class="contact-icons" :icons="$product->contacts"></x-contact-icons>
            </div>
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
                        <!-- @foreach ($product->contacts as $contact)
                        <x-badge class="star" badge_title="{{ $contact->number % 1 == 0 ? number_format($contact->number, 0) : number_format($contact->number, 1) }}" />
                        @endforeach -->
                        <x-badge :class="($badge_title === 'cerrado' ? 'closed' : ($badge_title === 'abierto' ? 'open' : ''))"
                        badge_title="{{ $badge_title }}" />
                    </div>
                    <h2>{{ $product->title }}</h2>
                </div>
            </div>
            <div class="product_body">
                <x-contact-icons class="contact-icons" :icons="$product->contacts"></x-contact-icons>
                <div class="product_body_content">
                    <div class="product_short_description">
                        <p class="text-large">{{ $product->short_description}}</p>
                    </div>
                    <div class="product_opening_hours">
                        <h4>Horario de atención</h4>
                        <p>Lunes a Viernes 10 a 18hs</p>
                    </div>
                    <hr class="divider">
                    <div class="product_description">
                        {!! $product->description !!}
                    </div>
                    <hr class="divider">
                    <div class="product_map">
                        <h4>Ubicación</h4>
                        <p class="text-large">Av. Falsa 123, Springfield, Argentina.</p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d289515.13637533726!2d-4.747192623938741!3d36.705252206827055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7259c44fdb212d%3A0x6025dc92c9ca32cf!2zTcOhbGFnYQ!5e0!3m2!1ses!2ses!4v1738499166003!5m2!1ses!2ses" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <hr class="divider">
                    <div class="product_rating">
                        <h4>Valoración de los clientes</h4>
                            <div class="flex gap-2 items-center">
                                <p class="text-4xl">5</p>
                                <x-icons.star class="h-auto w-8 fill-amber-500" />
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>