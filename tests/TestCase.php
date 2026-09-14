<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Stripe\ApiRequestor;
use Tests\Support\FakeStripeHttpClient;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        ApiRequestor::setHttpClient(new FakeStripeHttpClient);
    }
}
