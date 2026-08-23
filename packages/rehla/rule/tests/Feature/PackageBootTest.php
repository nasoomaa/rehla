<?php

use Rehla\Rule\Providers\RuleServiceProvider;
use Tests\Support\RulePackageTestCase;

uses(RulePackageTestCase::class)->group('rule', 'architecture');

test('rule package service provider is bound', function () {
    expect(app()->getProvider(RuleServiceProvider::class))->not->toBeNull();
});

test('rule package composer.json declares correct dependencies', function () {
    $composerJson = json_decode(file_get_contents(dirname(__DIR__, 2).'/composer.json'), true);

    expect($composerJson['name'])->toBe('rehla/rule')
        ->and($composerJson['require'])->toHaveKey('rehla/core');
});
