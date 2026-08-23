<?php

namespace Rehla\Core\SystemConfig;

use Rehla\Core\Contracts\SystemConfigRepository;
use Rehla\Core\Models\CoreConfig;

class DatabaseSystemConfigRepository implements SystemConfigRepository
{
    public function get(string $key, ?string $localeCode = null): mixed
    {
        $localeCode = $localeCode ?? '*';

        $config = CoreConfig::where('key', $key)
            ->where('locale_code', $localeCode)
            ->first();

        return $config?->value;
    }

    public function set(string $key, mixed $value, ?string $localeCode = null): void
    {
        $localeCode = $localeCode ?? '*';

        CoreConfig::updateOrCreate(
            ['key' => $key, 'locale_code' => $localeCode],
            ['value' => $value]
        );
    }
}
