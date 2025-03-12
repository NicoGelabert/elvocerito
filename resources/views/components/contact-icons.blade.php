@props(['icons' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    @foreach ($icons as $iconData)
        <div class="flex items-center md:gap-4">
            <x-icons.icon :name="$iconData['type']" />
            <div>
                <span class="text-sm font-semibold capitalize hidden md:block">{{ $iconData['type'] }}</span>
                <p class="text-xs text-gray-500 hidden md:block">{{ $iconData['info'] }}</p>
            </div>
        </div>
    @endforeach
</div>

