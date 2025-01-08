<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DemoAppLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     * @return \Illuminate\View\View
     */
    public function render(): View|Closure|string
    {
        return view('layouts.app-demo');
    }
}
