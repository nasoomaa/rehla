<?php

namespace Tests\Support\Architecture;

use App\Providers\AppServiceProvider;
use Rehla\AdminUsers\Providers\AdminUsersServiceProvider;
use Rehla\Api\Providers\ApiServiceProvider;
use Rehla\Applications\Providers\ApplicationsServiceProvider;
use Rehla\AuditLog\Providers\AuditLogServiceProvider;
use Rehla\CartRule\Providers\CartRuleServiceProvider;
use Rehla\Catalog\Providers\CatalogServiceProvider;
use Rehla\Checkout\Providers\CheckoutServiceProvider;
use Rehla\Core\Providers\CoreServiceProvider;
use Rehla\Customers\Providers\CustomersServiceProvider;
use Rehla\Dashboard\Providers\DashboardServiceProvider;
use Rehla\Datagrid\Providers\DatagridServiceProvider;
use Rehla\ImageCache\Providers\ImageCacheServiceProvider;
use Rehla\Media\Providers\MediaServiceProvider;
use Rehla\Notifications\Providers\NotificationsServiceProvider;
use Rehla\Payment\Providers\PaymentServiceProvider;
use Rehla\Rule\Providers\RuleServiceProvider;
use Rehla\Sales\Providers\SalesServiceProvider;

final class MonorepoConfiguration
{
    /**
     * @param array{
     *     repositories?: list<array{type?: mixed, url?: mixed}>,
     *     require?: array<string, mixed>
     * } $composer
     * @param  list<class-string>  $providers
     * @return list<string>
     */
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

    /**
     * @return list<string>
     */
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

    /**
     * @return list<class-string>
     */
    private function expectedProviders(): array
    {
        return [
            AppServiceProvider::class,
            CoreServiceProvider::class,
            DatagridServiceProvider::class,
            RuleServiceProvider::class,
            MediaServiceProvider::class,
            ImageCacheServiceProvider::class,
            CustomersServiceProvider::class,
            AdminUsersServiceProvider::class,
            CatalogServiceProvider::class,
            CartRuleServiceProvider::class,
            SalesServiceProvider::class,
            PaymentServiceProvider::class,
            CheckoutServiceProvider::class,
            ApplicationsServiceProvider::class,
            NotificationsServiceProvider::class,
            AuditLogServiceProvider::class,
            DashboardServiceProvider::class,
            ApiServiceProvider::class,
        ];
    }
}
