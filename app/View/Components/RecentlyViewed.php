<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecentlyViewed extends Component
{
    public $viewedProducts;
    public $viewedCategories;
    /**
     * Create a new component instance.
     * @param  mixed  $viewedProducts
     * @return void
     */
    public function __construct($viewedProducts, $viewedCategories)
    {
        $this->viewedProducts = $viewedProducts;
        $this->viewedCategories = $viewedCategories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recently-viewed');
    }
}
