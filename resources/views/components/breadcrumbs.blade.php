@props([
    'crumbs' => [],
    'backRoute' => '/home',
])
<div class="breadcrumbs">
    <div class="container flex gap-2 items-center overflow-hidden">
        <a href="/">
            <x-icons.home class="fill-gray_400" />
        </a>

        @foreach($crumbs as $crumb)
            <p>/</p>
            @if(!empty($crumb['url']))
                <a href="{{ $crumb['url'] }}" class="..."><p>{{ $crumb['label'] }}</p></a>
            @else
                <p class="truncate max-w-[180px] md:max-w-full">{{ $crumb['label'] }}</p>
            @endif
        @endforeach
    </div>
</div>
<div class="w-full container my-4 flex justify-between">
    <a class="bg-transparent" href="{{ $backRoute }}">
        <x-icons.arrow_left />
    </a>
    <x-button class="bg-transparent stroke-black" onclick="window.dispatchEvent(new CustomEvent('open-search-modal'))">
        <x-icons.search />
    </x-button>
</div>