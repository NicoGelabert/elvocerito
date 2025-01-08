<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Features extends Component
{
    public $features;
    /**
     * Create a new component instance.
     * @param  mixed  $features
     * @return void
     */
    public function __construct($features)
    {
        $this->features = $features;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.features');
    }
}
