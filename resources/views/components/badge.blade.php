@props([
    'badge_title' => 'Soy un badge',
])
<div {{ $attributes->merge(['class' => "w-fit rounded-md py-[2px] px-2 flex items-center gap-1"]) }}>
    @if ($attributes->has('class') && str_contains($attributes->get('class'), 'star'))
        <x-icons.star class="mr-2" />
    @endif
    <p class="text-badge">{{ $badge_title }}</p>
</div>
