<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AnunciantesDestacados extends Component
{
    public $anunciantes_destacados;
    /**
     * Create a new component instance.
     * @param  mixed  $anunciantes_destacados
     * @return void
     */
    /**
     * Create a new component instance.
     */
    public function __construct($anunciantesDestacados)
    {
        $this->anunciantes_destacados = $anunciantesDestacados;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.anunciantes-destacados');
    }
}
