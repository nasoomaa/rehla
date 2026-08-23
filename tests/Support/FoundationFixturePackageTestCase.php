<?php

namespace Tests\Support;

use Tests\Fixtures\Foundation\FixturePackageServiceProvider;

abstract class FoundationFixturePackageTestCase extends RehlaPackageTestCase
{
    /** @return list<class-string> */
    protected function packageProviders(): array
    {
        return [FixturePackageServiceProvider::class];
    }
}
