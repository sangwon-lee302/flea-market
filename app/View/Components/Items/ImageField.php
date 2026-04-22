<?php

namespace App\View\Components\Items;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageField extends Component
{
    public $src;

    public $displaySrc;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $src = null)
    {
        $this->src = $src;

        $this->displaySrc = $src ?? 'images/default-item-image.jpg';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.image-field');
    }
}
