<?php

namespace Rehla\Dashboard\Tests;

use Tests\TestCase;
use Rehla\Dashboard\Tests\Concerns\AdminTestBench;
use Rehla\Core\Tests\Concerns\CoreAssertions;

class AdminTestCase extends TestCase
{
    use AdminTestBench, CoreAssertions;
}
