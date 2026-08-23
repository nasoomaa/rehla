<?php

namespace Rehla\Core\Contracts;

interface MenuRegistry
{
    /**
     * @param string $key
     * @param array<string, mixed> $options
     * @return void
     */
    public function register(string $key, array $options): void;

    /**
     * @return array<string, array<string, mixed>>
     */
    public function items(): array;
}
