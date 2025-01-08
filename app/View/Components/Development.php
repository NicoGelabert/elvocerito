<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Development extends Component
{
    public $devprojects;
    /**
     * Create a new component instance.
     * @param  mixed  $devprojects
     * @return void
     */
    public function __construct($devprojects)
    {
        $this->devprojects = $devprojects;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.development');
    }
}
