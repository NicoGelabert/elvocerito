@php
    $sizes = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-lg',
    ];
@endphp

<div class="flex items-center justify-center rounded-full font-semibold text-white
            {{ $bgColor }} {{ $sizes[$size] ?? $sizes['md'] }}">
    {{ $initials }}
</div>
