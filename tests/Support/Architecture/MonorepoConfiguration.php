<?php

namespace Tests\Support\Architecture;

final class MonorepoConfiguration
{
    public function violations(array $composer, array $providers): array
    {
        $paths = $this->packagePaths();
        $pathSet = array_fill_keys($paths, true);
        $violations = [];
        $repositories = [];

        foreach ($composer['repositories'] ?? [] as $repository) {
            if (($repository['type'] ?? null) !== 'path') {
                continue;
            }

            $path = $repository['url'] ?? null;

            if (! is_string($path)) {
                $violations[] = 'path repository must declare a string URL';

                continue;
            }

            if (! str_starts_with($path, 'packages/rehla/')) {
                $violations[] = "path repository outside packages/rehla: {$path}";

                continue;
            }

            $repositories[] = $path;
        }

        foreach (array_count_values($repositories) as $path => $count) {
            if ($count > 1) {
                $violations[] = "duplicate path repository: {$path}";
            }
        }

        $repositorySet = array_fill_keys($repositories, true);

        foreach ($paths as $path) {
            if (! isset($repositorySet[$path])) {
                $violations[] = "missing path repository: {$path}";
            }
        }

        foreach (array_diff_key($repositorySet, $pathSet) as $path => $_) {
            $violations[] = "unexpected path repository: {$path}";
        }

        $requirements = $composer['require'] ?? [];

        foreach ($paths as $path) {
            $package = 'rehla/'.basename($path);
            $constraint = $requirements[$package] ?? null;

            if ($constraint === null) {
                $violations[] = "missing first-party root requirement: {$package}";
            } elseif ($constraint !== 'dev-main') {
                $violations[] = "first-party constraint for {$package} must be dev-main; actual {$constraint}";
            }
        }

        foreach ($requirements as $package => $_) {
            if (str_starts_with($package, 'rehla/') && ! isset($pathSet['packages/'.$package])) {
                $violations[] = "unexpected first-party root requirement: {$package}";
            }
        }

        if ($providers !== $this->expectedProviders()) {
            $violations[] = 'provider registration order does not match section 35';
        }

        $violations = array_values(array_unique($violations));
        sort($violations);

        return $violations;
    }

    private function packagePaths(): array
    {
        $paths = glob(dirname(__DIR__, 3).'/packages/rehla/*', GLOB_ONLYDIR) ?: [];
        $paths = array_map(
            static fn (string $path): string => 'packages/rehla/'.basename($path),
            $paths,
        );
        sort($paths);

        return $paths;
    }

    private function expectedProviders(): array
    {
        return [
            \App\Providers\AppServiceProvider::class,
            \Rehla\Core\Providers\CoreServiceProvider::class,
            \Rehla\Datagrid\Providers\DatagridServiceProvider::class,
            \Rehla\Rule\Providers\RuleServiceProvider::class,
            \Rehla\Media\Providers\MediaServiceProvider::class,
            \Rehla\ImageCache\Providers\ImageCacheServiceProvider::class,
            \Rehla\Customers\Providers\CustomersServiceProvider::class,
            \Rehla\AdminUsers\Providers\AdminUsersServiceProvider::class,
            \Rehla\Catalog\Providers\CatalogServiceProvider::class,
            \Rehla\CartRule\Providers\CartRuleServiceProvider::class,
            \Rehla\Sales\Providers\SalesServiceProvider::class,
            \Rehla\Payment\Providers\PaymentServiceProvider::class,
            \Rehla\Checkout\Providers\CheckoutServiceProvider::class,
            \Rehla\Applications\Providers\ApplicationsServiceProvider::class,
            \Rehla\Notifications\Providers\NotificationsServiceProvider::class,
            \Rehla\AuditLog\Providers\AuditLogServiceProvider::class,
            \Rehla\Dashboard\Providers\DashboardServiceProvider::class,
            \Rehla\Api\Providers\ApiServiceProvider::class,
        ];
    }
}
