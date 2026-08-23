<?php

namespace Rehla\Core\SystemConfig;

use Rehla\Core\Contracts\SystemConfigRepository;

class SystemConfigManager
{
    public function __construct(
        protected SystemConfigRepository $repository,
    ) {}

    public function get(string $key, mixed $default = null, ?string $localeCode = null): mixed
    {
        $value = $this->repository->get($key, $localeCode);

        return $value ?? $default;
    }

    public function set(string $key, mixed $value, ?string $localeCode = null): void
    {
        $this->repository->set($key, $value, $localeCode);
        
        // TODO: dispatch SystemConfigChanged — wired in Task 6
    }
}
