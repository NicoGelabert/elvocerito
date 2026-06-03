@props([
    'crumbs' => [],
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
                <p class="truncate max-w-[180px]">{{ $crumb['label'] }}</p>
            @endif
        @endforeach
    </div>
</div>