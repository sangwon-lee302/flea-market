<?php

namespace App\Http\Controllers;

use App\Category;
use App\Condition;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Support\Arr;

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

        return view('items.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::jsList();
        $conditions = Condition::jsList();

        return view('items.create', ['categories' => $categories, 'conditions' => $conditions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request, ItemService $itemService)
    {
        $user = auth()->user();

        $itemService->storeItem(
            $user,
            $request->file('image'),
            Arr::except($request->validated(), 'image'),
        );

        return redirect()->route('profiles.show', ['profile' => $user->profile]);
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
