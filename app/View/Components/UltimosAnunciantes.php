<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UltimosAnunciantes extends Component
{
    public $ultimos_anunciantes;
    /**
     * Create a new component instance.
     * @param  mixed  $ultimos_anunciantes
     * @return void
     */
    /**
     * Create a new component instance.
     */
    public function __construct($ultimosAnunciantes)
    {
        $this->ultimos_anunciantes = $ultimosAnunciantes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ultimos-anunciantes');
    }
}
