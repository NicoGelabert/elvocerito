@props(['name'])

@if ($name === 'fijo')
    <x-icons.phone-call />
@endif

@if ($name === 'móvil')
    <x-icons.smartphone />
@endif

@if ($name === 'whatsapp')
    <x-icons.whatsapp />
@endif

@if ($name === 'email')
    <x-icons.mail />
@endif

@if ($name === 'facebook')
    <x-icons.facebook />
@endif

@if ($name === 'instagram')
    <x-icons.instagram />
@endif

@if ($name === 'youtube')
    <x-icons.youtube />
@endif

@if ($name === 'tiktok')
    <x-icons.tiktok />
@endif