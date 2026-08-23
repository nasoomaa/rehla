<?php

namespace Rehla\Core\Contracts;

interface SystemConfigRepository
{
    /**
     * @param string $key
     * @param string|null $localeCode
     * @return mixed
     */
    public function get(string $key, ?string $localeCode = null): mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $localeCode
     * @return void
     */
    public function set(string $key, mixed $value, ?string $localeCode = null): void;
}
