@props(['images' => []])
<div x-data="{ open: false, imageSrc: '' }">
    <!-- Splide Slider -->
    <div {{ $attributes->merge(['class' => 'product_gallery_images splide']) }}>
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($images->skip(1) as $image)
                <li class="splide__slide">
                    <img src="{{ $image->url }}" @click="open = true; imageSrc = '{{ $image->url }}'" class="cursor-pointer">
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Lightbox -->
    <div x-show="open" class="lightbox" @click="open = false">
        <img :src="imageSrc" class="max-w-full max-h-full">
    </div>
</div>