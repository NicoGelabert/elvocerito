@props([
    'badge_title' => 'Soy un badge',
])
<div {{ $attributes->merge(['class' => "badge"]) }}>
    @if ($attributes->has('class') && str_contains($attributes->get('class'), 'star'))
        <x-icons.star class="mr-2" />
    @elseif($attributes->has('class') && (str_contains($attributes->get('class'), 'open') || str_contains($attributes->get('class'), 'closed')))
        <x-icons.dot class="mr-2" />
    @endif
    <p>{{ $badge_title }}</p>
</div>
