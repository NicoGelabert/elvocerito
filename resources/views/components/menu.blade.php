@props([
    'layout' => 'row', // Valor por defecto: disposición en fila
    'gap' => '4',      // Valor por defecto: espacio entre elementos
])

<nav {{ $attributes->merge(['class' => "flex flex-$layout gap-$gap w-full max-w-screen-xl mx-auto justify-between items-center"]) }}>
    <div class="logo flex justify-center">
        <x-application-logo/>
    </div>
    <x-search />
    <ul class="grid lg:grid-flow-col items-center justify-end gap-4 text-center">
        <li>
            <x-button href="#" class="btn btn-urgencies">urgencias <x-icons.urgencies /></x-button>
        </li>
    </ul>
</nav>