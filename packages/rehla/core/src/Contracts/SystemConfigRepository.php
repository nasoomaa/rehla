<?php

namespace Rehla\Core\Contracts;

interface SystemConfigRepository
{
    public function get(string $key, ?string $localeCode = null): mixed;

    public function set(string $key, mixed $value, ?string $localeCode = null): void;
}
