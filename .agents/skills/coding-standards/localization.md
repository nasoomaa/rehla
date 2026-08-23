# Localization

Rehla V1 supports two locales: **`en`** (English, LTR) and **`ar`** (Arabic, RTL).

All user-facing strings go through `trans()`. A string hardcoded in Blade or PHP is a defect.

## Creating Translation Files

Add keys to **both** locales when you add a string. Missing one is a defect.

**File:** `packages/rehla/catalog/src/Resources/lang/en/app.php`

```php
<?php

return [
    'admin' => [
        'services' => [
            'index' => [
                'title' => 'Services',
                'create-btn' => 'Create Service',
            ],
            'datagrid' => [
                'id'     => 'ID',
                'name'   => 'Name',
                'status' => 'Status',
                'edit'   => 'Edit',
                'delete' => 'Delete',
            ],
        ],
    ],
];
```

**File:** `packages/rehla/catalog/src/Resources/lang/ar/app.php`

```php
<?php

return [
    'admin' => [
        'services' => [
            'index' => [
                'title'      => 'الخدمات',
                'create-btn' => 'إنشاء خدمة',
            ],
            'datagrid' => [
                'id'     => 'المعرّف',
                'name'   => 'الاسم',
                'status' => 'الحالة',
                'edit'   => 'تعديل',
                'delete' => 'حذف',
            ],
        ],
    ],
];
```

## Loading Translations

In the service provider `boot()` method:

```php
$this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'catalog');
```

## Using Translations

```blade
{{-- In Blade templates --}}
{{ trans('catalog::app.admin.services.index.title') }}
@lang('catalog::app.admin.services.index.create-btn')
```

```php
// In controllers / PHP code
trans('catalog::app.admin.services.index.title')
__('catalog::app.admin.services.datagrid.status')
```

## Rules

- **Add to both locales simultaneously.** Never add only `en` and leave `ar` for later — it becomes permanent debt.
- **Arabic strings are real translations**, not placeholders. Invent nothing; source them from the product owner or existing wording in the codebase.
- **Key structure follows the view path:** `<package>::app.<area>.<feature>.<element>`.
- **Verify before claiming done.** Manually check that both lang files have the key — there is no automated checker in V1.
