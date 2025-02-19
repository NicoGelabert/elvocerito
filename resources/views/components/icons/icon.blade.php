@props(['name'])

@if ($name === 'fijo')
    <x-icons.phone-call />
@endif

@if ($name === 'movil')
    <x-icons.smartphone />
@endif

@if ($name === 'whatsapp')
    <x-icons.whatsapp />
@endif

@if ($name === 'email')
    <x-icons.mail />
@endif
