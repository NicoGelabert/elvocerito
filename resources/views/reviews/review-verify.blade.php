<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

        <div class="bg-white p-8 rounded shadow text-center max-w-lg w-full flex flex-col gap-8">

            <h2 class="text-2xl font-semibold mb-4">Verificación de Review</h2>

            @if($error ?? false)
                <p class="text-red-600 text-lg">{{ $message }}</p>
            @else
                <p class="text-green-600 text-lg">{{ $message }}</p>
            @endif

            <a href="/" class="btn btn-primary w-fit mx-auto">Volver al inicio</a>

        </div>

    </div>
</x-app-layout>