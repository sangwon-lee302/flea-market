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
        return DB::transaction(function () use ($user, $itemImage, $itemData) {
            $hashName = $itemImage->hashName();

            $finalItemData = array_merge(['image' => "images/{$hashName}"], Arr::except($itemData, 'categories'));

            $item = $user->items()->create($finalItemData);

            $categoryIds = Category::whereIn('name', $itemData['categories'])->pluck('id')->toArray();

            $item->categories()->attach($categoryIds);

            $itemImage->storeAs('images', $hashName, 'public');

            return $item;
        });
    }
}
