<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;

class ItemPolicy
{
    /**
     * Determine whether the user can purchase the item.
     *
     * The user is nullable so that guests are evaluated rather than denied
     * outright: item pages are public, and the purchase route's own `auth`
     * middleware is what sends a guest to the login screen.
     */
    public function purchase(?User $user, Item $item): bool
    {
        if ($this->isSold($item)) {
            return false;
        }

        return ! $this->isSeller($user, $item);
    }

    /**
     * Determine whether the user can like the item.
     */
    public function like(?User $user, Item $item): bool
    {
        return ! $this->isSeller($user, $item);
    }

    /**
     * An item is sold once an order exists for it; there is no sold column.
     */
    private function isSold(Item $item): bool
    {
        return $item->order()->exists();
    }

    private function isSeller(?User $user, Item $item): bool
    {
        return $user?->id === $item->user_id;
    }
}
