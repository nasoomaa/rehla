<?php

namespace Rehla\Core\Menu;

use Rehla\Core\Contracts\MenuRegistry;

class MenuManager implements MenuRegistry
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $items = [];

    public function register(string $key, array $options): void
    {
        $this->items[$key] = $options;
    }

    public function items(): array
    {
        return $this->items;
    }
}
