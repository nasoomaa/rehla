## Complete Dashboard Package Structure

```
packages/rehla/dashboard/
├── src/
│   ├── Providers/
│   │   └── DashboardServiceProvider.php
│   ├── Resources/
│   │   ├── assets/
│   │   │   ├── css/
│   │   │   │   └── app.css
│   │   │   ├── js/
│   │   │   │   └── app.js
│   │   │   ├── images/
│   │   │   └── fonts/
│   │   └── views/
│   │       ├── layouts/
│   │       │   └── master.blade.php
│   │       ├── dashboard/
│   │       │   └── index.blade.php
│   │       ├── components/
│   │       └── ...
│   └── Config/
│       ├── menu.php
│       └── acl.php
├── package.json
├── vite.config.js
├── tailwind.config.js
└── postcss.config.js
```

## Key Files Reference

| File | Purpose |
|------|---------|
| `config/themes.php` | Global theme configuration determining the active Admin Theme |
| `config/rehla-vite.php` | Vite asset configuration for `@rehlaVite` |
| `packages/rehla/dashboard/src/Providers/DashboardServiceProvider.php` | Dashboard package registration and views loading |
| `packages/rehla/dashboard/src/Resources/views/components/*` | Dashboard UI components |

## Common Pitfalls

- **Not clearing cache after theme config changes**: `php artisan optimize:clear` is often needed if you touch `config/themes.php`.
- **Forgetting to run composer dump-autoload**: After registering the package path repository.
- **Using `@vite` instead of `@rehlaVite`**: In Rehla, the dashboard uses `rehla-vite.php` so you must use `@rehlaVite(['...'], 'admin')`.
- **Not running npm build**: Without `npm run dev` or `npm run build`, the assets won't load and you'll get a manifest error.
- **Modifying published files**: Always work in `packages/rehla/dashboard/src/Resources/views/` instead of any public output folders.

## Testing Your Changes

Test your dashboard modifications by:
1. Ensuring `admin-default` is set correctly in `config/themes.php`
2. Starting `npm run dev` inside `packages/rehla/dashboard`
3. Logging into the admin panel (make sure your user has correct ACL)
4. Verifying responsive design and RTL layout when switching between English and Arabic
5. Testing hot reload during development
