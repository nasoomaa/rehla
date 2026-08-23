<?php

namespace Rehla\Core\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemConfigChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly string $key,
        public readonly ?string $localeCode = null
    ) {}
}
