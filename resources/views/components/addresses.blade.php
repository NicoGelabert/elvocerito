@props(['addresses' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    <div class="flex flex-col gap-2">
        @foreach ($addresses as $address)
        <div class="flex flex-col gap-8">
        <p>
            <b>
                {{ implode(' ', array_filter([
                 $address->title ? $address->title . ':' : '',
                ], fn($value) => !empty($value))) }}
            </b> 
            <a href="{{ $address->link }}">
                {{ implode(' ', array_filter([
                    $address->via,
                    $address->via_name,
                    $address->via_number ? $address->via_number . ',' : '',
                    $address->address_unit,
                    $address->city ? $address->city . '.' : '',
                    $address->zip_code ? $address->zip_code . ',' : '',
                    $address->province
                ], fn($value) => !empty($value))) }}
            </a>
        </p>
        @endforeach
        </div>
    </div>
</div>

