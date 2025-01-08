<div class="flex flex-col-reverse md:flex-row gap-8 justify-between">
    <div class="flex flex-col gap-8 md:gap-24 justify-between items-center h-auto md:w-1/2">
        <div class="w-full">
            <ul class="flex flex-col md:flex-row gap-2">
                @foreach($devprojects as $devproject)
                <li>
                    <img src="{{ $devproject->image }}" alt="{{ $devproject->name }}">
                    <p>{{ $devproject->name }}</p>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full flex gap-4">
            <x-button href="#contact">
                <i class="fi fi-rr-arrow-right arrow-to-right"></i> <span>{{__('Solicitar Presupuesto')}}</span>
            </x-button>
            <x-button class="btn-secondary" href="/servicios/diseno-web">
                <i class="fi fi-rr-arrow-right arrow-to-right"></i> <span>{{__('Ver Más')}}</span>
            </x-button>
        </div>
    </div>
    <div class="flex flex-col gap-8 md:gap-24 justify-between items-start h-auto md:w-1/2">
        <div class="w-full"><h4 class="normal-case">Sitios responsive y autoadministrables.</h4></div>
        <div class="w-full">
            <i class="hidden md:inline fi fi-br-arrow-up-left -rotate-90 text-4xl overflow-hidden"></i>
            <p class="text-lg">Creamos experiencias de usuario atractivas con un diseño web innovador para cautivar a su audiencia.</p>
        </div>
    </div>
</div>