<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeHeroBanner extends Component
{
    public $homeherobanners;
    /**
     * Create a new component instance.
     * @param  mixed  $homeherobanners
     * @return void
     */
    public function __construct($homeherobanners)
    {
        $this->homeherobanners = $homeherobanners;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home-hero-banner');
    }
}
