@props(['addresses' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    <div class="flex flex-col gap-2">
        @foreach ($addresses as $address)
        <div class="flex flex-col gap-8">
            <p><b>{{$address->title}}:</b> <a href="{{$address->link}}">{{$address->via}} {{$address->via_name}} {{$address->via_number}}, {{$address->address_unit}} {{$address->city}}. {{$address->zip_code}}, {{$address->province}}</a></p>
            {!! $address->google_maps !!}
            @endforeach
        </div>
    </div>
</div>

