@props(['product' => []])
@php
    use Carbon\Carbon;
    $horarios = $product->horarios->sortBy(fn($h) => array_search(strtolower($h->dia), [
        "lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"
    ]));
    $horarios = $product->horarios->map(function($horario) {
        return [
            'dia' => $horario->dia,
            'apertura' => Carbon::parse($horario->apertura)->format('H:i'),
            'cierre' => Carbon::parse($horario->cierre)->format('H:i')
        ];
    });
@endphp
<div x-data="verificarEstado({{ json_encode($horarios) }})" class="my-2">
    <x-badge x-bind:class="(estado === 'No Disponible' ? 'closed' : (estado === 'Disponible' ? 'open' : ''))">
        <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
    </x-badge>
</div>