<?php

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
use Tests\Support\Architecture\MonorepoConfiguration;

test('rejects missing or duplicated paths, unbound constraints, and provider reordering', function () {
    $composer = validMonorepoComposer();
    array_splice($composer['repositories'], 7, 1);
    $composer['repositories'][] = ['type' => 'path', 'url' => 'packages/rehla/core'];
    $composer['require']['rehla/core'] = '*@dev';

    $providers = approvedProviders();
    [$providers[1], $providers[8]] = [$providers[8], $providers[1]];

    $violations = (new MonorepoConfiguration)->violations($composer, $providers);

    expect($violations)
        ->toContain('missing path repository: packages/rehla/catalog')
        ->toContain('duplicate path repository: packages/rehla/core')
        ->toContain('first-party constraint for rehla/core must be dev-main; actual *@dev')
        ->toContain('provider registration order does not match section 35');
});

test('rejects coupled Composer repository and provider reordering', function () {
    $composer = validMonorepoComposer();
    [$composer['repositories'][0], $composer['repositories'][7]] = [$composer['repositories'][7], $composer['repositories'][0]];

    $providers = approvedProviders();
    [$providers[1], $providers[8]] = [$providers[8], $providers[1]];

    $violations = (new MonorepoConfiguration)->violations($composer, $providers);

    expect($violations)->toContain('provider registration order does not match section 35');
});
test('the root Composer configuration and provider registry are deterministic', function () {
    $composer = json_decode(file_get_contents(dirname(__DIR__, 2).'/composer.json'), true, flags: JSON_THROW_ON_ERROR);
    $providers = require dirname(__DIR__, 2).'/bootstrap/providers.php';

    expect($providers)->toBe(approvedProviders());
    expect((new MonorepoConfiguration)->violations($composer, $providers))->toBe([]);
});

/**
 * @return array{
 *     require: array<string, 'dev-main'>,
 *     repositories: list<array{type: 'path', url: string}>
 * }
 */
function validMonorepoComposer(): array
{
    $packages = [
        'core',
        'datagrid',
        'rule',
        'media',
        'image-cache',
        'customers',
        'admin-users',
        'catalog',
        'cart-rule',
        'sales',
        'payment',
        'checkout',
        'applications',
        'notifications',
        'audit-log',
        'dashboard',
        'api',
    ];

    return [
        'require' => array_fill_keys(array_map(
            static fn (string $package): string => 'rehla/'.$package,
            $packages,
        ), 'dev-main'),
        'repositories' => array_map(
            static fn (string $package): array => ['type' => 'path', 'url' => 'packages/rehla/'.$package],
            $packages,
        ),
    ];
}

/**
 * @return list<class-string>
 */
function approvedProviders(): array
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
