<?php

namespace Rehla\Dashboard\Tests;

use Rehla\Core\Tests\Concerns\CoreAssertions;
use Rehla\Dashboard\Tests\Concerns\AdminTestBench;
use Tests\TestCase;

class AdminTestCase extends TestCase
{
    use AdminTestBench, CoreAssertions;
}
