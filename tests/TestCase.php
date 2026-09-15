<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Stripe\ApiRequestor;
use Tests\Support\FakeStripeHttpClient;

abstract class TestCase extends BaseTestCase
{
    protected FakeStripeHttpClient $stripe;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stripe = new FakeStripeHttpClient;

        ApiRequestor::setHttpClient($this->stripe);
    }
}
