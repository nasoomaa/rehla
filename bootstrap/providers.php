<?php

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
