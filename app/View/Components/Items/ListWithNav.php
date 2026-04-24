<?php

namespace App\View\Components\Items;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ListWithNav extends Component
{
    public $items;

    public $links;

    /**
     * Create a new component instance.
     */
    public function __construct(array|Collection $items = [], array $links = [])
    {
        $this->items = $items;
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.items.list-with-nav');
    }

    /**
     * Get the route for each navigation link.
     */
    public function getRoute($routeName, $params = [], $excludingParams = [])
    {
        // do not change the order of request()->query() and $params below
        // because if both arrays have the same key, the corresponding value for the one in $params has to be prioritized.
        $allParams = array_merge(request()->query(), $params);

        $finalParams = array_diff_key($allParams, array_flip($excludingParams));

        return route($routeName, $finalParams);
    }

    /**
     * Check if the given page is currently active.
     */
    public function isActive($routeName, $params = []): bool
    {
        if (! request()->routeIs($routeName)) {
            return false;
        }

        $allParams = array_merge(request()->route()->parameters(), request()->query());

        $paramsToCheck = array_diff_key($allParams, ['keyword' => '']);

        if ($paramsToCheck !== $params) {
            return false;
        }

        return true;
    }
}
