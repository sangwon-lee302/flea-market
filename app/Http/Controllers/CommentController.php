<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Item $item)
    {
        $comment = new Comment;
        $comment->user()->associate(Auth::user());
        $comment->item()->associate($item);
        $comment->body = $request->validated('body');

        $comment->save();

        return back();
    }
}
