<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    | All ACLs related to dashboard will be placed here.
    |
    */
    [
        'key' => 'dashboard',
        'name' => 'dashboard::app.acl.dashboard',
        'route' => [
            'admin.dashboard.index',
            'admin.dashboard.stats',
        ],
        'sort' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sales
    |--------------------------------------------------------------------------
    |
    | All ACLs related to sales will be placed here.
    |
    */
    [
        'key' => 'sales',
        'name' => 'dashboard::app.acl.sales',
        'route' => 'admin.sales.orders.index',
        'sort' => 2,
    ], [
        'key' => 'sales.orders',
        'name' => 'dashboard::app.acl.orders',
        'route' => [
            'admin.sales.orders.index',
            'admin.sales.orders.search',
        ],
        'sort' => 1,
    ], [
        'key' => 'sales.orders.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.sales.orders.create',
            'admin.sales.orders.store',
            'admin.sales.orders.reorder',
            'admin.sales.cart.index',
            'admin.sales.cart.store',
            'admin.sales.cart.store_coupon',
            'admin.sales.cart.items.store',
            'admin.sales.cart.items.update',
            'admin.sales.cart.items.destroy',
            'admin.sales.cart.remove_coupon',
            'admin.sales.cart.addresses.store',
            'admin.sales.cart.shipping_methods.store',
            'admin.sales.cart.payment_methods.store',
            'admin.customers.customers.cart.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'sales.orders.view',
        'name' => 'dashboard::app.acl.view',
        'route' => [
            'admin.sales.orders.view',
            'admin.sales.orders.comment',
        ],
        'sort' => 2,
    ], [
        'key' => 'sales.orders.cancel',
        'name' => 'dashboard::app.acl.cancel',
        'route' => 'admin.sales.orders.cancel',
        'sort' => 3,
    ], [
        'key' => 'sales.invoices',
        'name' => 'dashboard::app.acl.invoices',
        'route' => 'admin.sales.invoices.index',
        'sort' => 2,
    ], [
        'key' => 'sales.invoices.view',
        'name' => 'dashboard::app.acl.view',
        'route' => [
            'admin.sales.invoices.view',
            'admin.sales.invoices.print',
            'admin.sales.invoices.send_duplicate_email',
        ],
        'sort' => 1,
    ], [
        'key' => 'sales.invoices.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.sales.invoices.store',
        'sort' => 2,
    ], [
        'key' => 'sales.invoices.update',
        'name' => 'dashboard::app.acl.edit',
        'route' => 'admin.sales.invoices.mass_update.state',
        'sort' => 3,
    ], [
        'key' => 'sales.shipments',
        'name' => 'dashboard::app.acl.shipments',
        'route' => 'admin.sales.shipments.index',
        'sort' => 3,
    ], [
        'key' => 'sales.shipments.view',
        'name' => 'dashboard::app.acl.view',
        'route' => 'admin.sales.shipments.view',
        'sort' => 1,
    ], [
        'key' => 'sales.shipments.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.sales.shipments.store',
        'sort' => 2,
    ], [
        'key' => 'sales.refunds',
        'name' => 'dashboard::app.acl.refunds',
        'route' => 'admin.sales.refunds.index',
        'sort' => 4,
    ], [
        'key' => 'sales.refunds.view',
        'name' => 'dashboard::app.acl.view',
        'route' => 'admin.sales.refunds.view',
        'sort' => 1,
    ], [
        'key' => 'sales.refunds.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.sales.refunds.store',
            'admin.sales.refunds.update_totals',
        ],
        'sort' => 2,
    ], [
        'key' => 'sales.transactions',
        'name' => 'dashboard::app.acl.transactions',
        'route' => [
            'admin.sales.transactions.index',
            'admin.sales.transactions.store',
        ],
        'sort' => 5,
    ], [
        'key' => 'sales.transactions.view',
        'name' => 'dashboard::app.acl.view',
        'route' => 'admin.sales.transactions.view',
        'sort' => 1,
    ], [
        'key' => 'sales.rma',
        'name' => 'dashboard::app.acl.rma.title',
        'route' => 'admin.sales.rma.requests.index',
        'sort' => 6,
    ], [
        'key' => 'sales.rma.requests',
        'name' => 'dashboard::app.acl.rma.requests.title',
        'route' => [
            'admin.sales.rma.requests.index',
            'admin.sales.rma.requests.view',
            'admin.sales.rma.requests.get-messages',
            'admin.sales.rma.requests.get-order-items',
            'admin.sales.rma.requests.get-resolution-reasons',
            'admin.sales.rma.requests.send-message',
            'admin.sales.rma.requests.update-status',
            'admin.sales.rma.requests.re-open',
        ],
        'sort' => 1,
    ], [
        'key' => 'sales.rma.requests.create',
        'name' => 'dashboard::app.acl.rma.requests.create',
        'route' => [
            'admin.sales.rma.requests.create',
            'admin.sales.rma.requests.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'sales.rma.reasons',
        'name' => 'dashboard::app.acl.rma.reasons.title',
        'route' => 'admin.sales.rma.reasons.index',
        'sort' => 2,
    ], [
        'key' => 'sales.rma.reasons.create',
        'name' => 'dashboard::app.acl.rma.reasons.create',
        'route' => 'admin.sales.rma.reasons.store',
        'sort' => 1,
    ], [
        'key' => 'sales.rma.reasons.edit',
        'name' => 'dashboard::app.acl.rma.reasons.edit',
        'route' => [
            'admin.sales.rma.reasons.edit',
            'admin.sales.rma.reasons.update',
            'admin.sales.rma.reasons.mass-update',
        ],
        'sort' => 2,
    ], [
        'key' => 'sales.rma.reasons.delete',
        'name' => 'dashboard::app.acl.rma.reasons.delete',
        'route' => [
            'admin.sales.rma.reasons.delete',
            'admin.sales.rma.reasons.mass-delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'sales.rma.rules',
        'name' => 'dashboard::app.acl.rma.rules.title',
        'route' => 'admin.sales.rma.rules.index',
        'sort' => 3,
    ], [
        'key' => 'sales.rma.rules.create',
        'name' => 'dashboard::app.acl.rma.rules.create',
        'route' => 'admin.sales.rma.rules.store',
        'sort' => 1,
    ], [
        'key' => 'sales.rma.rules.edit',
        'name' => 'dashboard::app.acl.rma.rules.edit',
        'route' => [
            'admin.sales.rma.rules.edit',
            'admin.sales.rma.rules.update',
            'admin.sales.rma.rules.mass-update',
        ],
        'sort' => 2,
    ], [
        'key' => 'sales.rma.rules.delete',
        'name' => 'dashboard::app.acl.rma.rules.delete',
        'route' => [
            'admin.sales.rma.rules.delete',
            'admin.sales.rma.rules.mass-delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'sales.rma.statuses',
        'name' => 'dashboard::app.acl.rma.statuses.title',
        'route' => 'admin.sales.rma.statuses.index',
        'sort' => 4,
    ], [
        'key' => 'sales.rma.statuses.create',
        'name' => 'dashboard::app.acl.rma.statuses.create',
        'route' => 'admin.sales.rma.statuses.store',
        'sort' => 1,
    ], [
        'key' => 'sales.rma.statuses.edit',
        'name' => 'dashboard::app.acl.rma.statuses.edit',
        'route' => [
            'admin.sales.rma.statuses.edit',
            'admin.sales.rma.statuses.update',
            'admin.sales.rma.statuses.mass-update',
        ],
        'sort' => 2,
    ], [
        'key' => 'sales.rma.statuses.delete',
        'name' => 'dashboard::app.acl.rma.statuses.delete',
        'route' => [
            'admin.sales.rma.statuses.delete',
            'admin.sales.rma.statuses.mass-delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'sales.rma.custom-fields',
        'name' => 'dashboard::app.acl.rma.custom-fields.title',
        'route' => 'admin.sales.rma.custom-fields.index',
        'sort' => 5,
    ], [
        'key' => 'sales.rma.custom-fields.create',
        'name' => 'dashboard::app.acl.rma.custom-fields.create',
        'route' => [
            'admin.sales.rma.custom-fields.create',
            'admin.sales.rma.custom-fields.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'sales.rma.custom-fields.edit',
        'name' => 'dashboard::app.acl.rma.custom-fields.edit',
        'route' => [
            'admin.sales.rma.custom-fields.edit',
            'admin.sales.rma.custom-fields.update',
            'admin.sales.rma.custom-fields.mass-update',
        ],
        'sort' => 2,
    ], [
        'key' => 'sales.rma.custom-fields.delete',
        'name' => 'dashboard::app.acl.rma.custom-fields.delete',
        'route' => [
            'admin.sales.rma.custom-fields.delete',
            'admin.sales.rma.custom-fields.mass-delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'sales.eu_withdrawals',
        'name' => 'dashboard::app.eu_withdrawal.acl.title',
        'route' => 'admin.sales.eu-withdrawals.index',
        'sort' => 10,
    ], [
        'key' => 'sales.eu_withdrawals.view',
        'name' => 'dashboard::app.eu_withdrawal.acl.view',
        'route' => 'admin.sales.eu-withdrawals.view',
        'sort' => 1,
    ], [
        'key' => 'sales.eu_withdrawals.decline',
        'name' => 'dashboard::app.eu_withdrawal.acl.decline',
        'route' => 'admin.sales.eu-withdrawals.decline',
        'sort' => 2,
    ], [
        'key' => 'sales.eu_withdrawals.mark_refunded',
        'name' => 'dashboard::app.eu_withdrawal.acl.mark_refunded',
        'route' => 'admin.sales.eu-withdrawals.mark_refunded',
        'sort' => 3,
    ], [
        'key' => 'sales.eu_withdrawals.resend_confirmation',
        'name' => 'dashboard::app.eu_withdrawal.acl.resend_confirmation',
        'route' => 'admin.sales.eu-withdrawals.resend_confirmation',
        'sort' => 4,
    ], [
        'key' => 'sales.bookings',
        'name' => 'dashboard::app.components.layouts.sidebar.booking-product',
        'route' => [
            'admin.sales.bookings.index',
            'admin.sales.bookings.get',
        ],
        'sort' => 11,
    ],

    /*
    |--------------------------------------------------------------------------
    | Catalog
    |--------------------------------------------------------------------------
    |
    | All ACLs related to catalog will be placed here.
    |
    */
    [
        'key' => 'catalog',
        'name' => 'dashboard::app.acl.catalog',
        'route' => 'admin.catalog.products.index',
        'sort' => 3,
    ], [
        'key' => 'catalog.products',
        'name' => 'dashboard::app.acl.products',
        'route' => [
            'admin.catalog.products.index',
            'admin.catalog.products.search',
            'admin.catalog.products.file.download',
            'admin.catalog.products.bundle.options',
            'admin.catalog.products.configurable.options',
            'admin.catalog.products.downloadable.options',
            'admin.catalog.products.grouped.options',
            'admin.catalog.products.simple.customizable-options',
            'admin.catalog.products.virtual.customizable-options',
            'admin.sales.booking-product.config',
            'admin.sales.booking-product.slots',
        ],
        'sort' => 1,
    ], [
        'key' => 'catalog.products.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.catalog.products.store',
        'sort' => 1,
    ], [
        'key' => 'catalog.products.copy',
        'name' => 'dashboard::app.acl.copy',
        'route' => 'admin.catalog.products.copy',
        'sort' => 2,
    ], [
        'key' => 'catalog.products.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.catalog.products.edit',
            'admin.catalog.products.update',
            'admin.catalog.products.update_inventories',
            'admin.catalog.products.mass_update',
            'admin.catalog.products.upload_link',
            'admin.catalog.products.upload_sample',
        ],
        'sort' => 3,
    ], [
        'key' => 'catalog.products.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.catalog.products.delete',
            'admin.catalog.products.mass_delete',
        ],
        'sort' => 4,
    ], [
        'key' => 'catalog.categories',
        'name' => 'dashboard::app.acl.categories',
        'route' => [
            'admin.catalog.categories.index',
            'admin.catalog.categories.search',
            'admin.catalog.categories.tree',
        ],
        'sort' => 2,
    ], [
        'key' => 'catalog.categories.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.catalog.categories.create',
            'admin.catalog.categories.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'catalog.categories.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.catalog.categories.edit',
            'admin.catalog.categories.update',
            'admin.catalog.categories.mass_update',
        ],
        'sort' => 2,
    ], [
        'key' => 'catalog.categories.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.catalog.categories.delete',
            'admin.catalog.categories.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'catalog.attributes',
        'name' => 'dashboard::app.acl.attributes',
        'route' => [
            'admin.catalog.attributes.index',
            'admin.catalog.attributes.options',
        ],
        'sort' => 3,
    ], [
        'key' => 'catalog.attributes.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.catalog.attributes.create',
            'admin.catalog.attributes.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'catalog.attributes.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.catalog.attributes.edit',
            'admin.catalog.attributes.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'catalog.attributes.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.catalog.attributes.delete',
            'admin.catalog.attributes.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'catalog.families',
        'name' => 'dashboard::app.acl.attribute-families',
        'route' => 'admin.catalog.families.index',
        'sort' => 4,
    ], [
        'key' => 'catalog.families.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.catalog.families.create',
            'admin.catalog.families.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'catalog.families.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.catalog.families.edit',
            'admin.catalog.families.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'catalog.families.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.catalog.families.delete',
        'sort' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    |
    | All ACLs related to customers will be placed here.
    |
    */
    [
        'key' => 'customers',
        'name' => 'dashboard::app.acl.customers',
        'route' => 'admin.customers.customers.index',
        'sort' => 4,
    ], [
        'key' => 'customers.customers',
        'name' => 'dashboard::app.acl.customers',
        'route' => [
            'admin.customers.customers.index',
            'admin.customers.customers.view',
            'admin.customers.customers.search',
            'admin.customers.customers.cart.items',
            'admin.customers.customers.compare.items',
            'admin.customers.customers.wishlist.items',
            'admin.customers.customers.orders.recent_items',
        ],
        'sort' => 1,
    ], [
        'key' => 'customers.customers.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.customers.customers.store',
        'sort' => 1,
    ], [
        'key' => 'customers.customers.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.customers.customers.update',
            'admin.customers.customers.mass_update',
            'admin.customers.customers.cart.items.delete',
            'admin.customers.customers.compare.items.delete',
            'admin.customers.customers.wishlist.items.delete',
        ],
        'sort' => 2,
    ], [
        'key' => 'customers.customers.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.customers.customers.delete',
            'admin.customers.customers.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'customers.customers.login_as_customer',
        'name' => 'dashboard::app.configuration.index.customer.settings.login-as-customer.title',
        'route' => 'admin.customers.customers.login_as_customer',
        'sort' => 4,
    ], [
        'key' => 'customers.addresses',
        'name' => 'dashboard::app.acl.addresses',
        'route' => 'admin.customers.customers.addresses.index',
        'sort' => 2,
    ], [
        'key' => 'customers.addresses.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.customers.customers.addresses.create',
            'admin.customers.customers.addresses.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'customers.addresses.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.customers.customers.addresses.edit',
            'admin.customers.customers.addresses.update',
            'admin.customers.customers.addresses.set_default',
        ],
        'sort' => 2,
    ], [
        'key' => 'customers.addresses.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.customers.customers.addresses.delete',
        'sort' => 3,
    ], [
        'key' => 'customers.note',
        'name' => 'dashboard::app.acl.note',
        'route' => 'admin.customer.note.store',
        'sort' => 3,
    ], [
        'key' => 'customers.groups',
        'name' => 'dashboard::app.acl.groups',
        'route' => 'admin.customers.groups.index',
        'sort' => 4,
    ], [
        'key' => 'customers.groups.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.customers.groups.store',
        'sort' => 1,
    ], [
        'key' => 'customers.groups.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => 'admin.customers.groups.update',
        'sort' => 2,
    ], [
        'key' => 'customers.groups.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.customers.groups.delete',
        'sort' => 3,
    ], [
        'key' => 'customers.reviews',
        'name' => 'dashboard::app.acl.reviews',
        'route' => 'admin.customers.customers.review.index',
        'sort' => 5,
    ], [
        'key' => 'customers.reviews.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.customers.customers.review.edit',
            'admin.customers.customers.review.update',
            'admin.customers.customers.review.mass_update',
        ],
        'sort' => 1,
    ], [
        'key' => 'customers.reviews.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.customers.customers.review.delete',
            'admin.customers.customers.review.mass_delete',
        ],
        'sort' => 2,
    ], [
        'key' => 'customers.gdpr_requests',
        'name' => 'dashboard::app.acl.gdpr',
        'route' => 'admin.customers.gdpr.index',
        'sort' => 6,
    ], [
        'key' => 'customers.gdpr_requests.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.customers.gdpr.edit',
            'admin.customers.gdpr.update',
        ],
        'sort' => 1,
    ], [
        'key' => 'customers.gdpr_requests.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.customers.gdpr.delete',
        'sort' => 2,
    ],

    /*
    |--------------------------------------------------------------------------
    | Marketing
    |--------------------------------------------------------------------------
    |
    | All ACLs related to marketing will be placed here.
    |
    */
    [
        'key' => 'marketing',
        'name' => 'dashboard::app.acl.marketing',
        'route' => 'admin.marketing.promotions.cart_rules.index',
        'sort' => 6,
    ], [
        'key' => 'marketing.promotions',
        'name' => 'dashboard::app.acl.promotions',
        'route' => 'admin.marketing.promotions.cart_rules.index',
        'sort' => 1,
    ], [
        'key' => 'marketing.promotions.cart_rules',
        'name' => 'dashboard::app.acl.cart-rules',
        'route' => [
            'admin.marketing.promotions.cart_rules.index',
            'admin.marketing.promotions.cart_rules.coupons.index',
        ],
        'sort' => 1,
    ], [
        'key' => 'marketing.promotions.cart_rules.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.marketing.promotions.cart_rules.create',
            'admin.marketing.promotions.cart_rules.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'marketing.promotions.cart_rules.copy',
        'name' => 'dashboard::app.acl.copy',
        'route' => 'admin.marketing.promotions.cart_rules.copy',
        'sort' => 1,
    ], [
        'key' => 'marketing.promotions.cart_rules.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.promotions.cart_rules.edit',
            'admin.marketing.promotions.cart_rules.update',
            'admin.marketing.promotions.cart_rules.coupons.store',
            'admin.marketing.promotions.cart_rules.coupons.delete',
            'admin.marketing.promotions.cart_rules.coupons.mass_delete',
        ],
        'sort' => 2,
    ], [
        'key' => 'marketing.promotions.cart_rules.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.promotions.cart_rules.delete',
        'sort' => 3,
    ], [
        'key' => 'marketing.promotions.catalog_rules',
        'name' => 'dashboard::app.acl.catalog-rules',
        'route' => 'admin.marketing.promotions.catalog_rules.index',
        'sort' => 1,
    ], [
        'key' => 'marketing.promotions.catalog_rules.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.marketing.promotions.catalog_rules.create',
            'admin.marketing.promotions.catalog_rules.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'marketing.promotions.catalog_rules.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.promotions.catalog_rules.edit',
            'admin.marketing.promotions.catalog_rules.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'marketing.promotions.catalog_rules.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.promotions.catalog_rules.delete',
        'sort' => 3,
    ], [
        'key' => 'marketing.communications',
        'name' => 'dashboard::app.acl.communications',
        'route' => 'admin.marketing.communications.email_templates.index',
        'sort' => 2,
    ], [
        'key' => 'marketing.communications.email_templates',
        'name' => 'dashboard::app.acl.email-templates',
        'route' => 'admin.marketing.communications.email_templates.index',
        'sort' => 1,
    ], [
        'key' => 'marketing.communications.email_templates.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.marketing.communications.email_templates.create',
            'admin.marketing.communications.email_templates.store',
        ],
        'sort' => 2,
    ], [
        'key' => 'marketing.communications.email_templates.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.communications.email_templates.edit',
            'admin.marketing.communications.email_templates.update',
        ],
        'sort' => 3,
    ], [
        'key' => 'marketing.communications.email_templates.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.communications.email_templates.delete',
        'sort' => 4,
    ], [
        'key' => 'marketing.communications.events',
        'name' => 'dashboard::app.acl.events',
        'route' => 'admin.marketing.communications.events.index',
        'sort' => 2,
    ], [
        'key' => 'marketing.communications.events.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.marketing.communications.events.store',
        'sort' => 1,
    ], [
        'key' => 'marketing.communications.events.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.communications.events.edit',
            'admin.marketing.communications.events.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'marketing.communications.events.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.communications.events.delete',
        'sort' => 3,
    ], [
        'key' => 'marketing.communications.campaigns',
        'name' => 'dashboard::app.acl.campaigns',
        'route' => 'admin.marketing.communications.campaigns.index',
        'sort' => 3,
    ], [
        'key' => 'marketing.communications.campaigns.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.marketing.communications.campaigns.create',
            'admin.marketing.communications.campaigns.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'marketing.communications.campaigns.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.communications.campaigns.edit',
            'admin.marketing.communications.campaigns.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'marketing.communications.campaigns.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.communications.campaigns.delete',
        'sort' => 3,
    ], [
        'key' => 'marketing.communications.subscribers',
        'name' => 'dashboard::app.acl.subscribers',
        'route' => 'admin.marketing.communications.subscribers.index',
        'sort' => 3,
    ], [
        'key' => 'marketing.communications.subscribers.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.communications.subscribers.edit',
            'admin.marketing.communications.subscribers.update',
        ],
        'sort' => 1,
    ], [
        'key' => 'marketing.communications.subscribers.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.communications.subscribers.delete',
        'sort' => 2,
    ], [
        'key' => 'marketing.search_seo',
        'name' => 'dashboard::app.acl.search-seo',
        'route' => 'admin.marketing.search_seo.url_rewrites.index',
        'sort' => 3,
    ], [
        'key' => 'marketing.search_seo.url_rewrites',
        'name' => 'dashboard::app.acl.url-rewrites',
        'route' => 'admin.marketing.search_seo.url_rewrites.index',
        'sort' => 1,
    ], [
        'key' => 'marketing.search_seo.url_rewrites.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.marketing.search_seo.url_rewrites.store',
        'sort' => 1,
    ], [
        'key' => 'marketing.search_seo.url_rewrites.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => 'admin.marketing.search_seo.url_rewrites.update',
        'sort' => 2,
    ], [
        'key' => 'marketing.search_seo.url_rewrites.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.marketing.search_seo.url_rewrites.delete',
            'admin.marketing.search_seo.url_rewrites.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'marketing.search_seo.search_terms',
        'name' => 'dashboard::app.acl.search-terms',
        'route' => 'admin.marketing.search_seo.search_terms.index',
        'sort' => 2,
    ], [
        'key' => 'marketing.search_seo.search_terms.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.marketing.search_seo.search_terms.store',
        'sort' => 1,
    ], [
        'key' => 'marketing.search_seo.search_terms.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => 'admin.marketing.search_seo.search_terms.update',
        'sort' => 2,
    ], [
        'key' => 'marketing.search_seo.search_terms.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.marketing.search_seo.search_terms.delete',
            'admin.marketing.search_seo.search_terms.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'marketing.search_seo.search_synonyms',
        'name' => 'dashboard::app.acl.search-synonyms',
        'route' => 'admin.marketing.search_seo.search_synonyms.index',
        'sort' => 3,
    ], [
        'key' => 'marketing.search_seo.search_synonyms.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.marketing.search_seo.search_synonyms.store',
        'sort' => 1,
    ], [
        'key' => 'marketing.search_seo.search_synonyms.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => 'admin.marketing.search_seo.search_synonyms.update',
        'sort' => 2,
    ], [
        'key' => 'marketing.search_seo.search_synonyms.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.marketing.search_seo.search_synonyms.delete',
            'admin.marketing.search_seo.search_synonyms.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'marketing.search_seo.sitemaps',
        'name' => 'dashboard::app.acl.sitemaps',
        'route' => 'admin.marketing.search_seo.sitemaps.index',
        'sort' => 4,
    ], [
        'key' => 'marketing.search_seo.sitemaps.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.marketing.search_seo.sitemaps.store',
        'sort' => 1,
    ], [
        'key' => 'marketing.search_seo.sitemaps.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.marketing.search_seo.sitemaps.edit',
            'admin.marketing.search_seo.sitemaps.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'marketing.search_seo.sitemaps.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.marketing.search_seo.sitemaps.delete',
        'sort' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Reporting
    |--------------------------------------------------------------------------
    |
    | All Reporting related to reporting will be placed here.
    |
    */
    [
        'key' => 'reporting',
        'name' => 'dashboard::app.acl.reporting',
        'route' => 'admin.reporting.sales.index',
        'sort' => 6,
    ], [
        'key' => 'reporting.sales',
        'name' => 'dashboard::app.acl.sales',
        'route' => [
            'admin.reporting.sales.index',
            'admin.reporting.sales.stats',
            'admin.reporting.sales.view',
            'admin.reporting.sales.view.stats',
            'admin.reporting.sales.export',
        ],
        'sort' => 1,
    ], [
        'key' => 'reporting.customers',
        'name' => 'dashboard::app.acl.customers',
        'route' => [
            'admin.reporting.customers.index',
            'admin.reporting.customers.stats',
            'admin.reporting.customers.view',
            'admin.reporting.customers.view.stats',
            'admin.reporting.customers.export',
        ],
        'sort' => 2,
    ], [
        'key' => 'reporting.products',
        'name' => 'dashboard::app.acl.products',
        'route' => [
            'admin.reporting.products.index',
            'admin.reporting.products.stats',
            'admin.reporting.products.view',
            'admin.reporting.products.view.stats',
            'admin.reporting.products.export',
        ],
        'sort' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | CMS
    |--------------------------------------------------------------------------
    |
    | All ACLs related to cms will be placed here.
    |
    */
    [
        'key' => 'cms',
        'name' => 'dashboard::app.acl.cms',
        'route' => 'admin.cms.index',
        'sort' => 7,
    ], [
        'key' => 'cms.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.cms.create',
            'admin.cms.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'cms.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.cms.edit',
            'admin.cms.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'cms.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.cms.delete',
            'admin.cms.mass_delete',
        ],
        'sort' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | All ACLs related to settings will be placed here.
    |
    */
    [
        'key' => 'settings',
        'name' => 'dashboard::app.acl.settings',
        'route' => 'admin.settings.users.index',
        'sort' => 8,
    ], [
        'key' => 'settings.locales',
        'name' => 'dashboard::app.acl.locales',
        'route' => 'admin.settings.locales.index',
        'sort' => 1,
    ], [
        'key' => 'settings.locales.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.settings.locales.store',
        'sort' => 1,
    ], [
        'key' => 'settings.locales.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.locales.edit',
            'admin.settings.locales.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.locales.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.locales.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.currencies',
        'name' => 'dashboard::app.acl.currencies',
        'route' => 'admin.settings.currencies.index',
        'sort' => 2,
    ], [
        'key' => 'settings.currencies.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.settings.currencies.store',
        'sort' => 1,
    ], [
        'key' => 'settings.currencies.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.currencies.edit',
            'admin.settings.currencies.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.currencies.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.settings.currencies.delete',
            'admin.settings.currencies.mass_delete',
        ],
        'sort' => 3,
    ], [
        'key' => 'settings.exchange_rates',
        'name' => 'dashboard::app.acl.exchange-rates',
        'route' => 'admin.settings.exchange_rates.index',
        'sort' => 3,
    ], [
        'key' => 'settings.exchange_rates.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.settings.exchange_rates.store',
        'sort' => 1,
    ], [
        'key' => 'settings.exchange_rates.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.exchange_rates.edit',
            'admin.settings.exchange_rates.update',
            'admin.settings.exchange_rates.update_rates',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.exchange_rates.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.exchange_rates.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.inventory_sources',
        'name' => 'dashboard::app.acl.inventory-sources',
        'route' => 'admin.settings.inventory_sources.index',
        'sort' => 4,
    ], [
        'key' => 'settings.inventory_sources.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.settings.inventory_sources.create',
            'admin.settings.inventory_sources.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'settings.inventory_sources.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.inventory_sources.edit',
            'admin.settings.inventory_sources.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.inventory_sources.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.inventory_sources.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.channels',
        'name' => 'dashboard::app.acl.channels',
        'route' => 'admin.settings.channels.index',
        'sort' => 5,
    ], [
        'key' => 'settings.channels.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.settings.channels.create',
            'admin.settings.channels.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'settings.channels.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.channels.edit',
            'admin.settings.channels.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.channels.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.channels.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.users',
        'name' => 'dashboard::app.acl.users',
        'route' => 'admin.settings.users.index',
        'sort' => 6,
    ], [
        'key' => 'settings.users.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.settings.users.store',
        'sort' => 1,
    ], [
        'key' => 'settings.users.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.users.edit',
            'admin.settings.users.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.users.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.users.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.roles',
        'name' => 'dashboard::app.acl.roles',
        'route' => 'admin.settings.roles.index',
        'sort' => 7,
    ], [
        'key' => 'settings.roles.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.settings.roles.create',
            'admin.settings.roles.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'settings.roles.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.roles.edit',
            'admin.settings.roles.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.roles.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.roles.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.taxes',
        'name' => 'dashboard::app.acl.taxes',
        'route' => 'admin.settings.taxes.categories.index',
        'sort' => 9,
    ], [
        'key' => 'settings.taxes.tax_categories',
        'name' => 'dashboard::app.acl.tax-categories',
        'route' => 'admin.settings.taxes.categories.index',
        'sort' => 1,
    ], [
        'key' => 'settings.taxes.tax_categories.create',
        'name' => 'dashboard::app.acl.create',
        'route' => 'admin.settings.taxes.categories.store',
        'sort' => 1,
    ], [
        'key' => 'settings.taxes.tax_categories.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.taxes.categories.edit',
            'admin.settings.taxes.categories.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.taxes.tax_categories.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.taxes.categories.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.taxes.tax_rates',
        'name' => 'dashboard::app.acl.tax-rates',
        'route' => 'admin.settings.taxes.rates.index',
        'sort' => 2,
    ], [
        'key' => 'settings.taxes.tax_rates.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.settings.taxes.rates.create',
            'admin.settings.taxes.rates.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'settings.taxes.tax_rates.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.taxes.rates.edit',
            'admin.settings.taxes.rates.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.taxes.tax_rates.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.taxes.rates.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.data_transfer',
        'name' => 'dashboard::app.acl.data-transfer',
        'route' => 'admin.settings.data_transfer.imports.index',
        'sort' => 10,
    ], [
        'key' => 'settings.data_transfer.imports',
        'name' => 'dashboard::app.acl.imports',
        'route' => 'admin.settings.data_transfer.imports.index',
        'sort' => 1,
    ], [
        'key' => 'settings.data_transfer.imports.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.settings.data_transfer.imports.create',
            'admin.settings.data_transfer.imports.store',
        ],
        'sort' => 1,
    ], [
        'key' => 'settings.data_transfer.imports.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.settings.data_transfer.imports.edit',
            'admin.settings.data_transfer.imports.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'settings.data_transfer.imports.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => 'admin.settings.data_transfer.imports.delete',
        'sort' => 3,
    ], [
        'key' => 'settings.data_transfer.imports.import',
        'name' => 'dashboard::app.acl.import',
        'route' => [
            'admin.settings.data_transfer.imports.import',
            'admin.settings.data_transfer.imports.validate',
            'admin.settings.data_transfer.imports.validate_chunk',
            'admin.settings.data_transfer.imports.validate_queued',
            'admin.settings.data_transfer.imports.validate_status',
            'admin.settings.data_transfer.imports.download_images',
            'admin.settings.data_transfer.imports.download_images_queued',
            'admin.settings.data_transfer.imports.download_images_status',
            'admin.settings.data_transfer.imports.start',
            'admin.settings.data_transfer.imports.link',
            'admin.settings.data_transfer.imports.index_data',
            'admin.settings.data_transfer.imports.stats',
            'admin.settings.data_transfer.imports.download',
            'admin.settings.data_transfer.imports.download_error_report',
            'admin.settings.data_transfer.imports.download_sample',
            'admin.settings.data_transfer.imports.download_sample_zip',
        ],
        'sort' => 4,
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | All ACLs related to configuration will be placed here.
    |
    */
    [
        'key' => 'configuration',
        'name' => 'dashboard::app.acl.configure',
        'route' => [
            'admin.configuration.index',
            'admin.configuration.store',
            'admin.configuration.search',
            'admin.configuration.download',
            'admin.configuration.cache-management.execute',
        ],
        'sort' => 9,
    ],

    /**
     * Appearance.
     */
    [
        'key' => 'appearance',
        'name' => 'dashboard::app.acl.appearance',
        'route' => 'admin.appearance.themes.index',
        'sort' => 9,
    ], [
        'key' => 'appearance.themes',
        'name' => 'dashboard::app.acl.themes',
        'route' => 'admin.appearance.themes.index',
        'sort' => 1,
    ], [
        'key' => 'appearance.themes.activate',
        'name' => 'dashboard::app.acl.activate',
        'route' => [
            'admin.appearance.themes.impact',
            'admin.appearance.themes.activate',
        ],
        'sort' => 1,
    ], [
        'key' => 'appearance.sections',
        'name' => 'dashboard::app.acl.sections',
        'route' => [
            'admin.appearance.sections.index',
        ],
        'sort' => 2,
    ], [
        'key' => 'appearance.sections.create',
        'name' => 'dashboard::app.acl.create',
        'route' => [
            'admin.appearance.sections.store',
            'admin.appearance.sections.duplicate',
        ],
        'sort' => 1,
    ], [
        'key' => 'appearance.sections.edit',
        'name' => 'dashboard::app.acl.edit',
        'route' => [
            'admin.appearance.sections.update',
            'admin.appearance.sections.status',
            'admin.appearance.sections.draft',
            'admin.appearance.sections.publish',
            'admin.appearance.sections.discard',
            'admin.appearance.sections.reorder',
            'admin.appearance.sections.media',
            'admin.appearance.sections.fields',
        ],
        'sort' => 2,
    ], [
        'key' => 'appearance.sections.delete',
        'name' => 'dashboard::app.acl.delete',
        'route' => [
            'admin.appearance.sections.delete',
        ],
        'sort' => 3,
    ],
];
