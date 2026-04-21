<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request('tab') === 'mylist') {
            $items = auth()->user()?->likedItems()->search(request('keyword'))
                ->withExists('order')
                ->get() ?? collect([]);
        } else {
            $items = Item::when(auth()->check(), fn ($q) => $q->whereNot('user_id', auth()->id()))
                ->search(request('keyword'))
                ->withExists('order')
                ->get();
        }

        return view('items.index', [
            'items' => $items,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load(['comments.user.profile']);
        $item->loadCount(['likes', 'comments']);

        $isLiked = auth()->check()
            ? auth()->user()->likedItems()->whereItemId($item->id)->exists()
            : false;

        $categories = $item->categories;

        return view('items.show', [
            'item'       => $item,
            'isLiked'    => $isLiked,
            'categories' => $categories,
        ]);
    }
}
