@props([
    'layout' => 'row', // Valor por defecto: disposición en fila
    'gap' => '16',      // Valor por defecto: espacio entre elementos
    'text-color' => 'gray_50',
])

<nav {{ $attributes->merge(['class' => "text-gray_50 h-full flex flex-$layout gap-$gap container items-center lg:justify-between"]) }}>
    <div class="logo flex justify-center">
        <x-logo/>
    </div>

    <ul class="flex flex-col lg:flex-row items-center justify-end gap-4 text-center">
        <li>
            <a href="/anunciantes">
                Ver todo
            </a>
        </li>
        <li>
            <a href="/categorias">
                Anunciá con nosotros
            </a>
        </li>
        <li>
            <x-button href="/anunciantes?urgencies=true" class="btn btn-urgencies"><x-icons.urgencies /> urgencias</x-button>
        </li>
        <li>
            <x-button href="/anunciantes?page=1&category=farmacias&on_duty=true" class="btn btn-on-duty"><x-icons.on_duty /> farmacias de turno</x-button>
        </li>
    </ul>
    <div class="flex flex-col gap-8 w-full lg:hidden absolute bottom-12 px-16">
        <hr class="divider">
        <x-social-icons />
    </div>
</nav>