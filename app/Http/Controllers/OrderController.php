<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Item $item)
    {
        $profile = Auth::user()->profile;

        return view('orders.create', [
            'item'    => $item,
            'profile' => $profile,
        ]);
    }
}
