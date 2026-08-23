<?php

namespace Rehla\Core\Contracts;

interface AclRegistry
{
    public function register(string $ability, string $description): void;

    public function allows(string $ability): bool;
}
