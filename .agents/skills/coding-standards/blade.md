# Blade Conventions

## Overview

Rehla UIs are Blade templates that lean heavily on **Blade components** and an inline **Vue 3** layer. New views must be indistinguishable from the surrounding code: same component idioms, the same `:` vs `::` binding rules, and the same indentation/attribute formatting. This skill captures those conventions so generated Blade matches the codebase exactly.

**These conventions are the same in every package.** What changes between packages is only a set of **namespace tokens** (the `x-<ns>::` component prefix and the `<ns>::` translation namespace); see "Per-package namespaces" below. When in doubt, open a nearby view in the *same package* and mirror it.

Core admin UIs live under `packages/rehla/dashboard/src/Resources/views/`; other packages follow the same directory shape under their own `src/Resources/views/`. Each package that ships components has a `components/example.blade.php` that demonstrates usage — treat it as the canonical reference.

## Per-package namespaces

A package's tokens come from two calls in its `ServiceProvider::boot()`:

```php
// Registers the `<ns>::` view + translation namespace  →  view('<ns>::…'), trans('<ns>::…')
$this->loadViewsFrom(__DIR__.'/../Resources/views', '<ns>');

// Registers the `x-<ns>::` anonymous component prefix   →  <x-<ns>::button />
Blade::anonymousComponentPath(__DIR__.'/../Resources/views/components', '<ns>');
```

So Dashboard registers `dashboard` (→ `x-dashboard::`, `trans('dashboard::…')`), and a domain package of your own — say `catalog` — registers `catalog` (→ `x-catalog::`, `trans('catalog::…')`).

What this means when working on a package:

- **Reuse Dashboard components freely.** `x-dashboard::` components/layouts are registered **globally**, so any admin page wraps in `<x-dashboard::layouts>` and uses `<x-dashboard::datagrid>`, `<x-dashboard::form.control-group.*>`, `<x-dashboard::modal>`, etc. You do **not** re-implement these.
- **Prefix only your own new components** with your package namespace: `<x-catalog::service-card>`.
- **Translations use your namespace:** `trans('catalog::app.services.index.title')`, with keys under `packages/rehla/catalog/src/Resources/lang/`.
- **Everything else is unchanged:** the `:`/`::` binding rules, the Vue `<v-x>` + x-template recipe, `@props`, formatting, ACL, and script stacking all apply verbatim.

Quick substitution map when moving between packages:

| Token | Dashboard | Your package (example: Catalog) |
|---|---|---|
| Own component prefix | `x-dashboard::` | `x-catalog::` |
| Translation namespace | `dashboard::app.…` | `catalog::app.…` |
| Layout to wrap in | `x-dashboard::layouts` | reuse `x-dashboard::layouts` |
| Event prefix | `rehla.dashboard.…` | `rehla.catalog.…` |

## When to Apply

Activate when:
- Creating or editing any `.blade.php` under Dashboard or domain packages
- Building a reusable Blade component (anonymous or Vue-backed)
- Wiring forms, datagrids, modals, drawers, tabs, or layouts
- Matching the project's attribute-binding, indentation, and blank-line style

## Directory & Component Structure

Pages sit under a feature folder (`catalog/`, `sales/`, `checkout/`, `customers/`, …); shared components sit under `components/`. Common components: `accordion, button, datagrid, drawer, dropdown, form, layouts, media, modal, shimmer, table, tabs`.

Namespaced invocation: `<x-dashboard::name>`, nested with dots: `<x-dashboard::form.control-group.control>`, `<x-dashboard::charts.bar>`.

## Component Invocation & Data Binding (most important rule)

Three distinct attribute forms — pick deliberately:

| Syntax | Resolves as | Use for | Example |
|---|---|---|---|
| `attr="text"` | static string | literals | `name="quantity"` |
| `:attr="expr"` | **Blade/PHP** expression | PHP values, routes, `trans()`, `old()` | `:src="route('admin.sales.orders.index')"` |
| `::attr="expr"` | escaped `:` → **literal `:attr` for Vue** | data passed into the Vue component | `::value="item?.quantity"`, `::labels="chartLabels"` |

The `::` (double colon) is Blade escaping a single `:` so the rendered HTML contains `:attr="expr"` for Vue to bind at runtime. Getting `:` vs `::` right is the single most common source of bugs.

**`::` only works on a Blade component tag** — `<x-dashboard::…>`. A plain custom element (`<v-quantity-changer>`) is passed through as literal HTML, so `::attr` reaches the browser **with both colons**, Vue does not recognise it as a binding, and the prop silently never arrives. On a plain `<v-…>` element write a single colon:

```blade
<x-dashboard::quantity-changer ::value="item.qty" />   {{-- component  → renders :value  --}}

<v-quantity-changer :value="item.qty"></v-quantity-changer>   {{-- plain element → write : --}}
```

The failure is silent and easy to misread: the prop is `undefined`, so any computed that walks it throws during render and the component freezes on whatever it last drew — typically its loading shimmer. If a `<v-…>` component renders its placeholder forever, check the colons first.

Named slots use `<x-slot:name> … </x-slot>`:

```blade
<x-dashboard::drawer>
    <x-slot:toggle>Toggle</x-slot>
    <x-slot:content>Body</x-slot>
</x-dashboard::drawer>
```

## The Two Component Types

### 1. Anonymous Blade component (`@props` + `$attributes`)

```blade
@props([
    'isActive' => false,
    'position' => 'right',
])

<div {{ $attributes->merge(['class' => 'box-shadow rounded bg-white dark:bg-gray-900']) }}>
    {{ $slot }}
</div>
```

- Declare inputs with `@props([...])`.
- Forward extra attributes with `$attributes->merge([...])`.
- Consume default slot with `{{ $slot }}`, named slots with `{{ $toggle }}` etc.

### 2. Vue-backed component (dominant pattern)

A thin custom-element wrapper + an inline x-template + registration on the global `app`:

```blade
@props([
    'name'  => '',
    'value' => 1,
])

<v-quantity-changer
    {{ $attributes->merge(['class' => 'flex items-center']) }}
    name="{{ $name }}"
    value="{{ $value }}"
>
</v-quantity-changer>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-quantity-changer-template"
    >
        <div>
            <span
                class="icon-minus cursor-pointer"
                role="button"
                @click="decrease"
            ></span>

            <p>@{{ quantity }}</p>
        </div>
    </script>

    <script type="module">
        app.component("v-quantity-changer", {
            template: '#v-quantity-changer-template',

            props: ['name', 'value'],

            data() {
                return {
                    quantity: this.value,
                };
            },

            methods: {
                decrease() {
                    this.$emit('change', --this.quantity);
                },
            },
        });
    </script>
@endPushOnce
```

Rules for this pattern:
- Wrapper element is `<v-name>`; template id is `#v-name-template`.
- Register with `app.component("v-name", { template: '#v-name-template', ... })`.
- Wrap scripts in `@pushOnce('scripts')` … `@endPushOnce` (the layout renders `@stack('scripts')`, so the block emits once no matter how many times the component is used).
- Emit literal Vue mustaches as `@{{ expr }}` so Blade does not try to render them.
- Pass data in via `::attr` (Vue binding) or `attr="{{ $php }}"` (server value).

## Page Skeleton

```blade
<x-dashboard::layouts>
    <x-slot:title>
        {{ trans('dashboard::app.admin.catalog.attributes.index.title') }}
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            {{ trans('dashboard::app.admin.catalog.attributes.index.title') }}
        </p>

        @if (Gate::allows('catalog.attributes.create'))
            <a href="{{ route('admin.catalog.attributes.create') }}">
                <div class="primary-button">
                    {{ trans('dashboard::app.admin.catalog.attributes.index.create-btn') }}
                </div>
            </a>
        @endif
    </div>

    <x-dashboard::datagrid :src="route('admin.catalog.attributes.index')" />
</x-dashboard::layouts>
```

## Cross-Cutting Idioms

- **Translations** — never hardcode UI strings. Use `trans('dashboard::app.…')` or `trans('catalog::app.…')`, always package-namespaced. When adding keys, add them to **all** supported locales under `Resources/lang/`.
- **ACL (admin only)** — gate create/edit/delete buttons and datagrid actions with `@if (Gate::allows('resource.action'))`. Authorization is via `spatie/laravel-permission` — never use `bouncer()`.
- **Forms** — `<x-dashboard::form :action="route(...)" method="POST">` wraps a VeeValidate `v-form`. Build fields with the control-group trio:
  ```blade
  <x-dashboard::form.control-group>
      <x-dashboard::form.control-group.label class="required">
          {{ trans('...') }}
      </x-dashboard::form.control-group.label>

      <x-dashboard::form.control-group.control
          type="text"
          name="name"
          rules="required"
          :value="old('name')"
          :label="trans('...')"
      />

      <x-dashboard::form.control-group.error control-name="name" />
  </x-dashboard::form.control-group>
  ```
  Validation is client-side; `control-name` on the error component must match the field `name`.
- **DataGrids** — `<x-dashboard::datagrid :src="route('…')" />`. Columns, filters, and actions are defined in a PHP `DataGrid` class; the Blade tag only points at the JSON endpoint.
- **Blade ↔ Vue escaping** — `@{{ vueVar }}` prints a literal Vue mustache; wrap a block in `v-pre` to keep Blade from touching `@`/`{{ }}` inside it.
- **RTL/Dark mode** — the layout sets `class="… dark …"` and `dir="ltr|rtl"` based on locale; use Tailwind `dark:` and `ltr:`/`rtl:` variants for theme/RTL awareness. Arabic (`ar`) is RTL by default.
