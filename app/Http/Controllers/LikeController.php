<?php

namespace App\Http\Controllers;

use App\Models\Item;

class LikeController extends Controller
{
    /**
     * Toggle a resource in storage.
     */
    public function toggle(Item $item)
    {
        $result = auth()->user()->likedItems()->toggle($item->id);

        $isAttached = count($result['attached']) > 0;

        $likesCount = $item->likes()->count();

        return response()->json(['isAttached' => $isAttached, 'likesCount' => $likesCount]);
    }
}
