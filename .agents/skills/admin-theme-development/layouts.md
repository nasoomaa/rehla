## Dashboard Layouts

> **Writing the Blade itself?** The **coding-standards** skill carries the markup rules —
> `:` vs `::` attribute binding, anonymous vs Vue-backed components, indentation, comment
> style, and where translations and `view_render_event` hooks go.

### Using the Dashboard Layout

```blade
<x-dashboard::layouts>
    <x-slot:title>
        {{ trans('dashboard::app.admin.page-title') }}
    </x-slot>

    {{-- Page Header --}}
    <div class="flex gap-4 justify-between max-sm:flex-wrap">
        <p class="py-[11px] text-xl text-gray-800 dark:text-white font-bold">
            {{ trans('dashboard::app.admin.heading') }}
        </p>
        <div class="flex gap-x-2.5 items-center">
            <button class="primary-button">
                {{ trans('dashboard::app.admin.action') }}
            </button>
        </div>
    </div>

    {{-- Page content --}}
    <div class="mt-8">
        Content goes here
    </div>
</x-dashboard::layouts>
```

### Layout Features

The dashboard layout automatically provides:
- **Sidebar Navigation**: Menu with collapsible sections populated from `menu.php`
- **Header**: Top navigation with user menu and notifications
- **Responsive Design**: Mobile-friendly layout
- **Dark Mode**: Built-in dark mode support (configured via Tailwind class)
- **RTL Support**: Native Arabic Right-to-Left styling

### Available Components

All dashboard components reside under `packages/rehla/dashboard/src/Resources/views/components/` and are invoked with `x-dashboard::`.

| Component | Usage | Description |
|-----------|-------|-------------|
| `<x-dashboard::accordion>` | Collapsible sections | Toggle content visibility |
| `<x-dashboard::button>` | Action buttons | Loading states supported |
| `<x-dashboard::charts.bar>` | Bar charts | Based on Chart.js |
| `<x-dashboard::datagrid>` | Data tables | Sorting, filtering, pagination |
| `<x-dashboard::drawer>` | Slide-out panels | Position: top/bottom/left/right |
| `<x-dashboard::dropdown>` | Dropdown menus | Position options available |
| `<x-dashboard::flat-picker.date>` | Date picker | Based on Flatpickr |
| `<x-dashboard::media.images>` | Image upload | Multiple images support |
| `<x-dashboard::modal>` | Dialog boxes | Header, content, footer slots |
| `<x-dashboard::quantity-changer>` | Quantity input | +/- buttons |
| `<x-dashboard::table>` | Data tables | Customizable thead/tbody |
| `<x-dashboard::tabs>` | Tab navigation | Position: left/right/center |
| `<x-dashboard::shimmer.*>` | Loading effects | Skeleton loaders |

### Creating the Base Master Layout

**File:** `packages/rehla/dashboard/src/Resources/views/layouts/master.blade.php`

```blade
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    
    {{-- Load assets via Rehla Vite --}}
    @rehlaVite([
        'src/Resources/assets/css/app.css',
        'src/Resources/assets/js/app.js'
    ], 'admin')
</head>
<body class="dark:bg-gray-900">
    {{-- Custom sidebar --}}
    @include('dashboard::layouts.sidebar')
    
    <div class="flex">
        {{-- Main content area --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
```
