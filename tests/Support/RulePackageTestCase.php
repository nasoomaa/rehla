<?php

namespace Tests\Support;

use Rehla\Rule\Providers\RuleServiceProvider;

abstract class RulePackageTestCase extends RehlaPackageTestCase
{
    protected function packageProviders(): array
    {
        return [
            RuleServiceProvider::class,
        ];
    }
}
