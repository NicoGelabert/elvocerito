<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InitialsAvatar extends Component
{
    public string $initials;
    public string $bgColor;
    public string $size;

    protected array $colors = [
        'bg-red-500',
        'bg-orange-500',
        'bg-amber-500',
        'bg-yellow-500',
        'bg-lime-500',
        'bg-emerald-500',
        'bg-teal-500',
        'bg-cyan-500',
        'bg-blue-500',
        'bg-indigo-500',
    ];

    public function __construct(
        string $name,
        string $lastName,
        string $size = 'md'
    ) {
        $this->initials = strtoupper(
            mb_substr($name, 0, 1) . mb_substr($lastName, 0, 1)
        );

        // Color "random" pero consistente según el nombre
        $hash = crc32($this->initials);
        $this->bgColor = $this->colors[$hash % count($this->colors)];

        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.initials-avatar');
    }
}
