@props(['icons' => []])
<div {{ $attributes->merge(['class' => 'grid grid-cols-4 gap-4 mt-2 justify-between']) }}>
    @foreach ($icons as $iconData)
        <div class="flex flex-col text-center lg:text-left lg:flex-row items-center gap-2">
            <x-icons.icon :name="$iconData['icon']" />
            <div>
                <span class="text-sm font-semibold hidden md:block">{{ $iconData['name'] }}</span>
                <p class="text-xs text-gray-500 hidden md:block">{{ $iconData['text'] }}</p>
            </div>
        </div>
    @endforeach
</div>

