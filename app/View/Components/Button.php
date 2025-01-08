<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $class;
    public $href;
    /**
     * Create a new component instance.
     * @param string $type
     * @param string $class
     * @param string|null $href
     */
    public function __construct($type = 'submit', $class = 'btn-primary', $href = null)
    {
        $this->type = $type;
        $this->class = $class;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
