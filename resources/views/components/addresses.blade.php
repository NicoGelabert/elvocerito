@props(['addresses' => []])
<div {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}>
    @foreach ($addresses as $index => $address)
    @php
        $popoverId = 'popover-map-' . $index;
    @endphp
    <div class="flex gap-2">
        <a href="{{ $address->link }}">
            <p>
                {{ implode(' ', array_filter([
                    $address->via,
                    $address->via_name,
                    $address->via_number ? $address->via_number . ',' : '',
                    $address->address_unit,
                    $address->city ? $address->city . '.' : '',
                    $address->zip_code ? $address->zip_code . ',' : '',
                    $address->province
                ], fn($value) => !empty($value))) }}
            </p>
        </a>
        @if($address->google_maps)
        <a href="#" class="" data-popover-target="{{ $popoverId }}">
            <x-icons.map  />
        </a>
        <div data-popover id="{{ $popoverId }}" role="tooltip" class="relative z-10 invisible inline-block w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0">
            <div class="google_map">
                {!! $address->google_maps !!}
            </div>
            <div data-popper-arrow></div>
        </div>
        @endif
    </div>
    @endforeach
</div>
<script>
    document.addEventListener('click', function (event) {
        document.querySelectorAll('[data-popover]').forEach(function (popover) {
            const trigger = document.querySelector(`[data-popover-target="${popover.id}"]`);
            if (!popover.contains(event.target) && !trigger.contains(event.target)) {
                popover.classList.add('invisible', 'opacity-0');
            }
        });
    });

    document.querySelectorAll('[data-popover-target]').forEach(function (trigger) {
        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = trigger.getAttribute('data-popover-target');
            const popover = document.getElementById(targetId);

            // Toggle visibility
            if (popover.classList.contains('invisible')) {
                popover.classList.remove('invisible', 'opacity-0');
            } else {
                popover.classList.add('invisible', 'opacity-0');
            }
        });
    });
</script>