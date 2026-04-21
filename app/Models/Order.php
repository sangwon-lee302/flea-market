<?php

namespace App\Models;

use App\PaymentMethod;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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
     * Prepare for redirecting to the actual billing page.
     */
    public static function prepareCheckout(Item $item, string $paymentMethod): string
    {
        $paymentTypes = match (PaymentMethod::from($paymentMethod)) {
            PaymentMethod::Konbini => ['konbini'],
            PaymentMethod::Card    => ['card'],
        };

        Stripe::setApiKey(config('services.stripe.secret'));

        $checkout_session = Session::create([
            'payment_method_types' => $paymentTypes,
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount'  => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('orders.success', ['item' => $item]),
            'cancel_url'  => route('orders.create', ['item' => $item]),
        ]);

        return $checkout_session->url;
    }

    /**
     * Store a new order in storage.
     */
    public static function storeOrder(User $user, Item $item, array $orderData): void
    {
        $profile = $user->profile;

        $shippingAddress = session('shipping_address', [
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

        session()->forget('shipping_address');
    }
}
