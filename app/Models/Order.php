<?php

namespace App\Models;

use App\PaymentMethod;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $item_id
 * @property int $payment_method
 * @property string $shipping_postal_code
 * @property string $shipping_address
 * @property string $shipping_building
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 *
 * @property-read Item $item
 * @property-read User $user
 *
 * @mixin \Eloquent
 */
#[Fillable(['payment_method', 'shipping_postal_code', 'shipping_address', 'shipping_building'])]
class Order extends Model
{
    public function casts()
    {
        return [
            'payment_method' => PaymentMethod::class,
        ];
    }

    /**
     * Store a new order in storage.
     */
    public static function storeOrder(User $user, Item $item, array $orderData): void
    {
        $profile = $user->profile;

        $shippingAddress = session('temp_address', [
            'postal_code' => $profile->postal_code,
            'address'     => $profile->address,
            'building'    => $profile->building,
        ]);

        $order = $user->orders()->make([
            'payment_method'       => $orderData['payment_method'],
            'shipping_postal_code' => $shippingAddress['postal_code'],
            'shipping_address'     => $shippingAddress['address'],
            'shipping_building'    => $shippingAddress['building'],
        ]);
        $order->item_id = $item->id;

        $order->save();

        $item->is_sold = true;
        $item->save();

        session()->forget('temp_address');
    }
}
