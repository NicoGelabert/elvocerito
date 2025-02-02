@props(['name'])

@if ($name === 'phone')
    <x-icons.phone-call />
@endif

@if ($name === 'mobile')
    <x-icons.smartphone />
@endif

@if ($name === 'whatsapp')
    <x-icons.whatsapp />
@endif

@if ($name === 'email')
    <x-icons.mail />
@endif
