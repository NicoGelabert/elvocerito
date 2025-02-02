@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
        @if(trim(strip_tags($slot)) === 'Ver todas')
            <x-icons.chevron-down class="-rotate-90" />
        @endif
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $class]) }}>
        {{ $slot }}
    </button>
@endif