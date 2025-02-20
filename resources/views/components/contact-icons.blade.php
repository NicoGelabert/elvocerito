@props(['icons' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    @foreach ($icons as $iconData)
        <div class="flex flex-col text-center lg:text-left lg:flex-row items-center gap-2">
            <x-icons.icon :name="$iconData['type']" />
            <div>
                <span class="text-sm font-semibold hidden md:block">{{ $iconData['type'] }}</span>
                <p class="text-xs text-gray-500 hidden md:block">{{ $iconData['info'] }}</p>
            </div>
        </div>
    @endforeach
</div>

