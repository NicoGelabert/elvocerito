@props([
    'layout' => 'row', // Valor por defecto: disposición en fila
    'gap' => '16',      // Valor por defecto: espacio entre elementos
    'text-color' => 'gray_50',
])

<nav {{ $attributes->merge(['class' => "text-gray_50 h-full flex flex-$layout gap-$gap container items-center justify-between"]) }}>
    <div class="logo flex justify-center">
        <x-logo/>
    </div>

    <ul class="grid lg:grid-flow-col items-center justify-end gap-4 text-center">
        <li>
            <a href="/categorias">
                Categorías
            </a>
        </li>
        <li>
            <a href="/categorias">
                Anunciá con nosotros
            </a>
        </li>
        <li>
            <x-button href="/urgencias" class="btn btn-urgencies">urgencias <x-icons.urgencies /></x-button>
        </li>
    </ul>
</nav>