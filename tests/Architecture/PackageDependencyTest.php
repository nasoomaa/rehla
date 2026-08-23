<?php

use Tests\Support\Architecture\PackageDependencyGraph;

test('rejects a circular first-party package dependency', function () {
    $packagesRoot = sys_get_temp_dir().'/rehla-package-dependency-'.bin2hex(random_bytes(8));

    try {
        writePackageManifest($packagesRoot.'/core', 'rehla/core', ['rehla/catalog' => '*']);
        writePackageManifest($packagesRoot.'/catalog', 'rehla/catalog', ['rehla/core' => '*']);

        $violations = (new PackageDependencyGraph)->violations($packagesRoot, [
            'rehla/core' => ['rehla/catalog'],
            'rehla/catalog' => ['rehla/core'],
        ]);

        expect($violations)->toContain('circular dependency: rehla/catalog -> rehla/core -> rehla/catalog');
    } finally {
        removePackageFixture($packagesRoot);
    }
});

test('the first-party package manifests match the approved dependency graph', function () {
    $expected = [
        'rehla/core' => [],
        'rehla/datagrid' => ['rehla/core'],
        'rehla/rule' => ['rehla/core'],
        'rehla/media' => ['rehla/core'],
        'rehla/image-cache' => ['rehla/core', 'rehla/media'],
        'rehla/customers' => ['rehla/core'],
        'rehla/admin-users' => ['rehla/core'],
        'rehla/catalog' => ['rehla/core'],
        'rehla/cart-rule' => ['rehla/core', 'rehla/rule', 'rehla/catalog', 'rehla/customers'],
        'rehla/sales' => ['rehla/core', 'rehla/catalog', 'rehla/customers'],
        'rehla/payment' => ['rehla/core', 'rehla/sales', 'rehla/media'],
        'rehla/checkout' => ['rehla/core', 'rehla/catalog', 'rehla/customers', 'rehla/cart-rule', 'rehla/sales', 'rehla/payment'],
        'rehla/applications' => ['rehla/core', 'rehla/sales', 'rehla/customers', 'rehla/media'],
        'rehla/notifications' => ['rehla/core'],
        'rehla/audit-log' => ['rehla/core'],
        'rehla/dashboard' => ['rehla/core', 'rehla/datagrid', 'rehla/catalog', 'rehla/customers', 'rehla/admin-users', 'rehla/cart-rule', 'rehla/sales', 'rehla/payment', 'rehla/checkout', 'rehla/applications', 'rehla/media', 'rehla/image-cache', 'rehla/audit-log'],
        'rehla/api' => ['rehla/core', 'rehla/catalog', 'rehla/customers', 'rehla/cart-rule', 'rehla/checkout', 'rehla/sales', 'rehla/payment', 'rehla/applications'],
    ];

    expect((new PackageDependencyGraph)->violations(dirname(__DIR__, 2).'/packages/rehla', $expected))->toBe([]);
});

/**
 * @param  array<string, string>  $require
 */
function writePackageManifest(string $directory, string $name, array $require): void
{
    mkdir($directory, 0777, true);

    file_put_contents($directory.'/composer.json', json_encode([
        'name' => $name,
        'require' => $require,
    ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
}

function removePackageFixture(string $directory): void
{
    foreach (glob($directory.'/*/composer.json') ?: [] as $manifest) {
        unlink($manifest);
        rmdir(dirname($manifest));
    }

    rmdir($directory);
}
