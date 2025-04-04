@props(['anunciante_destacado' => []])
@php
    use Carbon\Carbon;
    $horarios = $anunciante_destacado->horarios->sortBy(fn($h) => array_search(strtolower($h->dia), [
        "lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"
    ]));
    $horarios = $anunciante_destacado->horarios->map(function($horario) {
        return [
            'dia' => $horario->dia,
            'apertura' => Carbon::parse($horario->apertura)->format('H:i'),
            'cierre' => Carbon::parse($horario->cierre)->format('H:i')
        ];
    });
@endphp
<div x-data="verificarEstado({{ json_encode($horarios) }})">
    <x-badge x-bind:class="(estado === 'Cerrado' ? 'closed' : (estado === 'Abierto' ? 'open' : ''))">
        <span x-text="estado"></span> <!-- Muestra Abierto o Cerrado -->
    </x-badge>
</div>