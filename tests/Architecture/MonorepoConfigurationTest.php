<?php

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

function approvedProviders(): array
{
    return [
        App\Providers\AppServiceProvider::class,
        Rehla\Core\Providers\CoreServiceProvider::class,
        Rehla\Datagrid\Providers\DatagridServiceProvider::class,
        Rehla\Rule\Providers\RuleServiceProvider::class,
        Rehla\Media\Providers\MediaServiceProvider::class,
        Rehla\ImageCache\Providers\ImageCacheServiceProvider::class,
        Rehla\Customers\Providers\CustomersServiceProvider::class,
        Rehla\AdminUsers\Providers\AdminUsersServiceProvider::class,
        Rehla\Catalog\Providers\CatalogServiceProvider::class,
        Rehla\CartRule\Providers\CartRuleServiceProvider::class,
        Rehla\Sales\Providers\SalesServiceProvider::class,
        Rehla\Payment\Providers\PaymentServiceProvider::class,
        Rehla\Checkout\Providers\CheckoutServiceProvider::class,
        Rehla\Applications\Providers\ApplicationsServiceProvider::class,
        Rehla\Notifications\Providers\NotificationsServiceProvider::class,
        Rehla\AuditLog\Providers\AuditLogServiceProvider::class,
        Rehla\Dashboard\Providers\DashboardServiceProvider::class,
        Rehla\Api\Providers\ApiServiceProvider::class,
    ];
}
