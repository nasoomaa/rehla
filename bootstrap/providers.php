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
use rehla\imagecache\Providers\ImageCacheServiceProvider;
use Rehla\Media\Providers\MediaServiceProvider;
use Rehla\Notifications\Providers\NotificationsServiceProvider;
use Rehla\Payment\Providers\PaymentServiceProvider;
use Rehla\Rule\Providers\RuleServiceProvider;
use Rehla\Sales\Providers\SalesServiceProvider;

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
