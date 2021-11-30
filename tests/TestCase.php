<?php

namespace Tests;

use Illuminate\Support\Facades\Cache;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }
}
