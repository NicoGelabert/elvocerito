<div class="flex flex-col md:flex-row gap-8 justify-between">
    <div class="flex flex-col gap-8 md:gap-24 justify-between items-center h-auto md:w-1/2">
        <div class="w-full">
            <ul class="flex flex-wrap gap-2">
                @foreach($clients as $client)
                <li class="max-w-20 h-auto">
                    <img src="{{ $client->image }}" alt="{{ $client->name }}">
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full flex gap-4">
            <x-button href="#">
                <i class="fi fi-rr-arrow-right arrow-to-right"></i> <span>{{__('Solicitar Presupuesto')}}</span>
            </x-button>
            <x-button class="btn-secondary" href="#">
                <i class="fi fi-rr-arrow-right arrow-to-right"></i> <span>{{__('Ver Más')}}</span>
            </x-button>
        </div>
    </div>
    <div class="flex flex-col gap-8 md:gap-24 justify-between items-center h-auto md:w-1/2">
        <div class="w-full"><h3 class="normal-case">Convertimos ideas
        en realidad.</h3></div>
        <div class="w-full"><p class="text-lg">Somos Chimi Design, una agencia de diseño que combina creatividad y experiencia para ofrecer soluciones atractivas de diseño gráfico y web que ayuden a las empresas a tener éxito.</p></div>
    </div>
</div>