@props(['icons' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    @foreach ($icons as $iconData)
    <a href="{{ $iconData->link }}">
        <x-icons.icon :name="$iconData['rrss']" />
    </a>
    @endforeach
</div>