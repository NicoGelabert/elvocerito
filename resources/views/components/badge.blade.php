@props([
    'badge_title' => 'Soy un badge',
])
<div {{ $attributes->merge(['class' => "badge"]) }}>
    @if ($attributes->has('class') && str_contains($attributes->get('class'), 'star'))
        <x-icons.star />
    @elseif($attributes->has('class') && (str_contains($attributes->get('class'), 'open') || str_contains($attributes->get('class'), 'closed')))
        <x-icons.dot/>
    @elseif($attributes->has('class') && (str_contains($attributes->get('class'), 'urgencies')))
        <x-icons.urgencies/>
    @endif
    <span>{{ $slot->isEmpty() ? $badge_title : $slot }}</span>
</div>
