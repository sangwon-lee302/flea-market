<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request('tab') === 'mypage') {
            $items = Auth::user()?->likedItems()->get() ?? collect([]);
        } else {
            $items = Item::when(Auth::check(), fn ($q) => $q->whereNot('user_id', Auth::id()))->get();
        }

        return view('items.index', compact('items'));
    }
}
