<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Clients extends Component
{
    public $clients;
    /**
     * Create a new component instance.
     * @param  mixed  $clients
     * @return void
     */
    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.clients');
    }
}
