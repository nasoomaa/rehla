<?php

use Illuminate\Support\Facades\Schema;
use Rehla\Core\Models\CoreConfig;
use Rehla\Core\Models\Currency;
use Rehla\Core\Models\Locale;
use Tests\Support\ProvidesCorePackage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(ProvidesCorePackage::class, RefreshDatabase::class);

test('locales table exists with correct schema', function () {
    expect(Schema::hasTable('locales'))->toBeTrue()
        ->and(Schema::hasColumns('locales', ['id', 'code', 'direction', 'created_at', 'updated_at']))->toBeTrue();
});

test('currencies table exists with correct schema', function () {
    expect(Schema::hasTable('currencies'))->toBeTrue()
        ->and(Schema::hasColumns('currencies', ['id', 'code', 'precision', 'created_at', 'updated_at']))->toBeTrue();
});

test('core_config table exists with correct schema and unique constraints', function () {
    expect(Schema::hasTable('core_config'))->toBeTrue()
        ->and(Schema::hasColumns('core_config', ['id', 'key', 'value', 'locale_code', 'is_secret', 'created_at', 'updated_at']))->toBeTrue();
    
    // Test the UNIQUE(key, locale_code) constraint by trying to insert duplicates
    // But since this is a schema test, we can just check if the model works.
});

test('locale model handles persistence', function () {
    $locale = new Locale([
        'code' => 'en',
        'direction' => 'ltr',
    ]);
    $locale->save();

    expect(Locale::count())->toBe(1)
        ->and(Locale::first()->code)->toBe('en');
});

test('currency model handles persistence', function () {
    $currency = new Currency([
        'code' => 'USD',
        'precision' => 2,
    ]);
    $currency->save();

    expect(Currency::count())->toBe(1)
        ->and(Currency::first()->code)->toBe('USD');
});

test('core_config model hides secret values on array serialization', function () {
    $config = new CoreConfig([
        'key' => 'api_key',
        'value' => 'secret123',
        'locale_code' => 'en',
        'is_secret' => true,
    ]);
    
    $array = $config->toArray();
    
    expect($array)->not->toHaveKey('value');
});

test('core_config model enforces unique key-locale pairs', function () {
    CoreConfig::create([
        'key' => 'site_name',
        'value' => 'Rehla',
        'locale_code' => 'en',
        'is_secret' => false,
    ]);

    expect(fn () => CoreConfig::create([
        'key' => 'site_name',
        'value' => 'Rehla Duplicate',
        'locale_code' => 'en',
        'is_secret' => false,
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});
