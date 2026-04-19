<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle a resource in storage.
     */
    public function toggle(Item $item)
    {
        $result = Auth::user()->likedItems()->toggle($item->id);

        $isAttached = count($result['attached']) > 0;

        $likesCount = $item->likes()->count();

        return response()->json([
            'isAttached' => $isAttached,
            'likesCount' => $likesCount,
        ]);
    }
}
