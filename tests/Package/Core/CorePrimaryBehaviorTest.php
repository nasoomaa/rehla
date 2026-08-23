<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rehla\Core\Acl\AclManager;
use Rehla\Core\Http\Middleware\EnsureRequestId;
use Rehla\Core\Menu\MenuManager;
use Rehla\Core\Support\RequestId;
use Rehla\Core\SystemConfig\SystemConfigManager;
use Tests\Support\CorePackageTestCase;

uses(CorePackageTestCase::class, RefreshDatabase::class);

test('menu manager can register and retrieve items', function () {
    $manager = app(MenuManager::class);
    $manager->register('dashboard', ['route' => 'admin.dashboard', 'icon' => 'home']);

    $items = $manager->items();
    expect($items)->toHaveKey('dashboard')
        ->and($items['dashboard']['route'])->toBe('admin.dashboard');
});

test('acl manager can register abilities and check them', function () {
    $manager = app(AclManager::class);
    $manager->register('view-dashboard', 'Can view the main dashboard');

    // Test that the ability is registered. (Access check logic might be tested more thoroughly in Task 5)
    expect($manager->allows('view-dashboard'))->toBeTrue()
        ->and($manager->allows('unknown-ability'))->toBeFalse(); // Fails closed as per spec
});

test('system config manager can get and set config', function () {
    $manager = app(SystemConfigManager::class);

    $manager->set('site_name', 'Rehla Platform');

    expect($manager->get('site_name'))->toBe('Rehla Platform')
        ->and($manager->get('unknown_key'))->toBeNull();
});

test('request id middleware injects a unique id', function () {
    $middleware = new EnsureRequestId;
    $request = new Request;

    $response = $middleware->handle($request, function ($req) {
        expect($req->headers->has('X-Request-ID'))->toBeTrue();

        // Return a dummy response
        return new Response('ok');
    });

    expect($response->headers->has('X-Request-ID'))->toBeTrue();
    expect(RequestId::current())->not->toBeNull();
});
