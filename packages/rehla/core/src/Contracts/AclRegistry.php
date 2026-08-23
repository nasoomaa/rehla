<?php

namespace Rehla\Core\Contracts;

interface AclRegistry
{
    /**
     * @param string $ability
     * @param string $description
     * @return void
     */
    public function register(string $ability, string $description): void;

    /**
     * @param string $ability
     * @return bool
     */
    public function allows(string $ability): bool;
}
