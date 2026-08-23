<?php

namespace Rehla\Core\Acl;

use Rehla\Core\Contracts\AclRegistry;

class AclManager implements AclRegistry
{
    /**
     * @var array<string, string>
     */
    protected array $abilities = [];

    public function register(string $ability, string $description): void
    {
        $this->abilities[$ability] = $description;
    }

    public function allows(string $ability): bool
    {
        return isset($this->abilities[$ability]);
    }
}
