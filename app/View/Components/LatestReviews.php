<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestReviews extends Component
{
    public $ultimasReviews;
    /**
     * Create a new component instance.
     * @param  mixed  $ultimasReviews
     * @return void
     */
    public function __construct($ultimasReviews)
    {
        $this->ultimasReviews = $ultimasReviews;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.latest-reviews');
    }
}
