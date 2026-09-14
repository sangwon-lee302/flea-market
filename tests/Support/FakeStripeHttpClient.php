<?php

namespace Tests\Support;

use Stripe\HttpClient\ClientInterface;

/**
 * Stands in for Stripe's real HTTP client during tests so that checkout
 * flows never make a live network call. Returns just enough of a Checkout
 * Session payload for the app to redirect on ->url.
 */
class FakeStripeHttpClient implements ClientInterface
{
    public function request($method, $absUrl, $headers, $params, $hasFile, $apiMode = 'v1', $maxNetworkRetries = null)
    {
        $body = json_encode([
            'id'     => 'cs_test_fake',
            'object' => 'checkout.session',
            'url'    => 'https://checkout.stripe.com/c/pay/cs_test_fake',
        ]);

        return [$body, 200, []];
    }
}
