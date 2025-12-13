<div class="flex items-center space-x-2">

    <!-- ESTRELLAS -->
    <div class="flex">
        @for ($i = 1; $i <= 5; $i++)
            @php
                $full = $rating >= $i;
                $half = $rating >= ($i - 0.5) && $rating < $i;
            @endphp

            <svg
                class="h-4 w-4 {{ $full || $half ? 'fill-amber-300' : 'fill-gray-300' }}"
                viewBox="0 0 20 20"
            >
                @if($half)
                    <defs>
                        <linearGradient id="half-star">
                            <stop offset="50%" stop-color="#fcd34d" />
                            <stop offset="50%" stop-color="#e5e7eb" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                @else
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                @endif
            </svg>
        @endfor
    </div>

    <!-- NÚMERO -->
    <span class="text-sm font-semibold text-gray-600">
        {{ number_format($rating, 1) }}
    </span>
</div>
