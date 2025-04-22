@props(['addresses' => []])
<div {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}>
    @foreach ($addresses as $address)
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
        <a href="#" class="" data-popover-target="popover-map">
            <x-icons.map  />
        </a>
        <div data-popover id="popover-map" role="tooltip" class="relative z-10 invisible inline-block w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0">
            <div class="google_map">
                {!! $address->google_maps !!}
            </div>
            <div data-popper-arrow></div>
        </div>
        @endif
    </div>
    @endforeach
</div>

