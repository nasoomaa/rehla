<?php

namespace Rehla\Core\SystemConfig;

use Rehla\Core\Contracts\SystemConfigRepository;
use Rehla\Core\Events\SystemConfigChanged;

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

        SystemConfigChanged::dispatch($key, $localeCode);
    }
}
