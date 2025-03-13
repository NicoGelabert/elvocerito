@props(['icons' => []])
<div {{ $attributes->merge(['class' => '']) }}>
    @foreach ($icons as $iconData)
        @php
            $href = '#'; // Valor por defecto si no coincide con ninguna condición
            
            if ($iconData['type'] === 'fijo' || $iconData['type'] === 'movil') {
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
            <div class="flex items-center md:gap-4">
                <x-icons.icon :name="$iconData['type']" />
                <div>
                    <span class="text-sm font-semibold capitalize hidden md:block">{{ $iconData['type'] }}</span>
                    <p class="text-xs text-gray-500 hidden md:block">{{ $iconData['info'] }}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>

