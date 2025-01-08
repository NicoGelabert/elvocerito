<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Faq extends Component
{
    public $faqs;
    /**
     * Create a new component instance.
     * @param  mixed  $portfolios
     * @return void
     */
    public function __construct($faqs)
    {
        $this->faqs = $faqs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.faq');
    }
}
