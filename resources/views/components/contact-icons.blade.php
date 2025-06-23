@props(['icons' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    @foreach ($icons as $iconData)
        @php
            $href = '#'; // Valor por defecto si no coincide con ninguna condición
            
            if ($iconData['type'] === 'fijo' || $iconData['type'] === 'móvil') {
                $href = "tel:{$iconData['info']}";
            } elseif ($iconData['type'] === 'whatsapp') {
                $href = "https://wa.me/" . preg_replace('/\D/', '', $iconData['info']); // Solo números
            } elseif ($iconData['type'] === 'email') {
                $href = "mailto:{$iconData['info']}";
            } elseif ($iconData['type'] === 'facebook' || $iconData['type'] === 'instagram') {
                $href = $iconData['info']; // URL directa de la red social
            }
        @endphp
        <a href="{{ $href }}">
            <div class="contacto {{ !$loop->last ? 'border-b border-gray-200 pb-4 mb-4' : '' }}">
                <x-icons.icon :name="$iconData['type']" />
                <div>
                    <span class="block text-right text-base lg:text-sm font-semibold capitalize">{{ $iconData['type'] }}</span>
                    <p class="text-right text-base text-gray-500 -mt-1 lg:mt-0">{{ $iconData['info'] }}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>

