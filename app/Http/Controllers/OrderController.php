<?php

namespace App\Http\Controllers;

use App\Models\Item;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Item $item)
    {
        return view('orders.create', compact('item'));
    }
}
