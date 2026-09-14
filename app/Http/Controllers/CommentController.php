<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Item $item)
    {
        $comment = $item->comments()->make(['body' => $request->validated('body')]);
        $comment->user()->associate(auth()->user());

        $comment->save();

        return redirect()->route('items.show', $item);
    }
}
