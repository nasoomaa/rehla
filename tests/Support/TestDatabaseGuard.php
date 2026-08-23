<?php

namespace Tests\Support;

final class TestDatabaseGuard
{
    public static function assertSafe(string $environment, string $connection, string $database): void
    {
        if (! self::isSafe($environment, $connection, $database)) {
            throw new \RuntimeException('Unsafe test database configuration.');
        }
    }

    private static function isSafe(string $environment, string $connection, string $database): bool
    {
        return $environment === 'testing'
            && $connection === 'pgsql'
            && str_ends_with($database, '_testing');
    }
}
