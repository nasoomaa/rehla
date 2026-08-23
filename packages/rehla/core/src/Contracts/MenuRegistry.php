<?php

namespace Rehla\Core\Contracts;

interface MenuRegistry
{
    /**
     * @param  array<string, mixed>  $options
     */
    public function register(string $key, array $options): void;

    /**
     * @return array<string, array<string, mixed>>
     */
    public function items(): array;
}
