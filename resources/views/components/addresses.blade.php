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
        <x-icons.map  />
        @endif
    </div>
    @endforeach
</div>

