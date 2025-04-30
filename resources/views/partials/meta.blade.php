@props([
    'title' => 'El Vocerito. Servicios cerca tuyo.',
    'description' => 'Guía de servicios en la zona sur del Gran Buenos Aires.',
    'keywords' => 'Guía de servicios, Zona Sur, profesionales, comercios, oficios, empresas locales',
    'canonical' => url('/'),
    'image' => asset('storage/common/iso_vocerito.svg'),
    'type' => 'website',
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ is_array($keywords) ? implode(', ', $keywords) : $keywords }}">
<link rel="canonical" href="{{ $canonical }}">
