<?php

namespace Tests\Support;

use Stripe\HttpClient\ClientInterface;

/**
 * Stands in for Stripe's real HTTP client during tests so that checkout
 * flows never make a live network call.
 *
 * It remembers the metadata sent when a Checkout Session is created so that a
 * later retrieve can echo it back, which is what the success route verifies
 * before it stores an order.
 */
class FakeStripeHttpClient implements ClientInterface
{
    public const SESSION_ID = 'cs_test_fake';

    /** @var array<string, mixed> */
    private array $metadata = [];

    private string $paymentStatus = 'paid';

    /**
     * Simulate a buyer returning from a checkout that was never paid.
     */
    public function markUnpaid(): void
    {
        $this->paymentStatus = 'unpaid';
    }

    public function request($method, $absUrl, $headers, $params, $hasFile, $apiMode = 'v1', $maxNetworkRetries = null)
    {
        if (array_key_exists('metadata', $params)) {
            $this->metadata = $params['metadata'];
        }

        $body = json_encode([
            'id'             => self::SESSION_ID,
            'object'         => 'checkout.session',
            'url'            => 'https://checkout.stripe.com/c/pay/'.self::SESSION_ID,
            'payment_status' => $this->paymentStatus,
            'metadata'       => (object) $this->metadata,
        ]);

        return [$body, 200, []];
    }
}
