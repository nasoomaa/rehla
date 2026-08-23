<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Rehla\Core\Events\SystemConfigChanged;
use Rehla\Core\SystemConfig\SystemConfigManager;
use Tests\Support\CorePackageTestCase;

uses(CorePackageTestCase::class, RefreshDatabase::class);

test('SystemConfigChanged event is dispatched when config is set', function () {
    Event::fake();

    $manager = app(SystemConfigManager::class);
    $manager->set('maintenance_mode', 'true', 'en');

    Event::assertDispatched(SystemConfigChanged::class, function ($event) {
        return $event->key === 'maintenance_mode'
            && $event->localeCode === 'en';
    });
});
