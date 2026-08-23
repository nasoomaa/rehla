<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\TestDatabaseGuard;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        TestDatabaseGuard::assertSafe(
            getenv('APP_ENV') ?: '',
            getenv('DB_CONNECTION') ?: '',
            getenv('DB_DATABASE') ?: '',
        );

        parent::setUp();
    }
}
