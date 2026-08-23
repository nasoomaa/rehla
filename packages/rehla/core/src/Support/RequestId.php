<?php

namespace Rehla\Core\Support;

class RequestId
{
    protected static ?string $current = null;

    public static function set(string $id): void
    {
        static::$current = $id;
    }

    public static function current(): ?string
    {
        return static::$current;
    }

    public static function clear(): void
    {
        static::$current = null;
    }
}
