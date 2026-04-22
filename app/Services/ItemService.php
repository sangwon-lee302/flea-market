<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ItemService
{
    /**
     * Store a new item resource in storage.
     */
    public function storeItem(User $user, UploadedFile $itemImage, array $itemData): Item
    {
        $item = DB::transaction(function () use ($user, $itemImage, $itemData) {
            $hashName = $itemImage->hashName();

            $item        = $user->items()->make(Arr::except($itemData, 'categories'));
            $item->image = "images/{$hashName}";

            $item->save();

            $categoryIds = Category::whereIn('name', $itemData['categories'])->pluck('id');

            $item->categories()->sync($categoryIds);

            $itemImage->storeAs('images', $hashName, 'public');

            return $item;
        });

        return $item;
    }
}
