<?php

use Illuminate\Http\Request;
use Rehla\Core\Acl\AclManager;
use Rehla\Core\Http\Middleware\EnsureRequestId;
use Rehla\Core\Models\CoreConfig;
use Rehla\Core\Support\RequestId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ProvidesCorePackage;

uses(ProvidesCorePackage::class, RefreshDatabase::class);

test('acl fails closed for unknown protected ability', function () {
    $manager = app(AclManager::class);
    
    // Explicitly check that an ability not registered returns false.
    // This is already checked in PrimaryBehaviorTest, but we enforce it here as an invariant.
    expect($manager->allows('super-admin'))->toBeFalse();
});

test('secret system config values are redacted on read', function () {
    // We test this via Eloquent toArray which is the standard boundary for API responses/logs.
    CoreConfig::create([
        'key' => 'stripe_secret',
        'value' => 'sk_test_123',
        'locale_code' => 'en',
        'is_secret' => true,
    ]);
    
    $config = CoreConfig::where('key', 'stripe_secret')->first();
    
    expect($config->value)->toBe('sk_test_123') // Can read internally
        ->and($config->toArray())->not->toHaveKey('value'); // Redacted on serialization
});

test('request IDs cannot be supplied as arbitrary trusted audit identity', function () {
    $middleware = new EnsureRequestId();
    
    // Malicious user sends a fake request ID
    $request = new Request();
    $request->headers->set('X-Request-ID', 'fake-malicious-id');
    
    $response = $middleware->handle($request, function ($req) {
        $id = $req->header('X-Request-ID');
        
        // The middleware should overwrite it with a new UUID, or at least ignore the fake one.
        // Let's assert it is not the fake one.
        expect($id)->not->toBe('fake-malicious-id');
        
        return new \Illuminate\Http\Response('ok');
    });
});
