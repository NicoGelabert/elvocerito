<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Benefits extends Component
{
    public $tags;
    /**
     * Create a new component instance.
     * @param  mixed  $tags
     * @return void
     */
    public function __construct($tags)
    {
        $this->tags = $tags;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.benefits');
    }
}
