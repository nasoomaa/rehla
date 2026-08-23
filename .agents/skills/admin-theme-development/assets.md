## Vite-Powered Assets in Rehla

Rehla uses Vite for compiling assets, integrated via a specialized `config/rehla-vite.php` file to handle theme-specific assets (instead of standard Laravel Vite config).

### Step 1: Asset Configuration Files

**File:** `packages/rehla/dashboard/package.json`

```json
{
    "name": "rehla-dashboard",
    "private": true,
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "autoprefixer": "^10.4.14",
        "axios": "^1.1.2",
        "laravel-vite-plugin": "^0.7.2",
        "postcss": "^8.4.23",
        "tailwindcss": "^3.3.2",
        "vite": "^4.0.0"
    }
}
```

**File:** `packages/rehla/dashboard/vite.config.js`

```javascript
import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig(({ mode }) => {
    const envDir = "../../../";

    Object.assign(process.env, loadEnv(mode, envDir));

    return {
        build: {
            emptyOutDir: true,
        },
        envDir,
        server: {
            host: process.env.VITE_HOST || "localhost",
            port: process.env.VITE_ADMIN_PORT || 5174,
            cors: true,
        },
        plugins: [
            laravel({
                hotFile: "../../../public/admin-default-vite.hot",
                publicDirectory: "../../../public",
                buildDirectory: "themes/admin/default/build",
                input: [
                    "src/Resources/assets/css/app.css",
                    "src/Resources/assets/js/app.js",
                ],
                refresh: true,
            }),
        ],
    };
});
```

**File:** `packages/rehla/dashboard/tailwind.config.js`

```javascript
module.exports = {
    content: [
        "./src/Resources/**/*.blade.php",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            // Dashboard specific theme extensions
        },
    },
    plugins: [],
};
```

### Step 2: Ensure Rehla Vite Config Matches

**File:** `config/rehla-vite.php`

```php
'viters' => [
    'admin' => [
        'hot_file' => 'admin-default-vite.hot',
        'build_directory' => 'themes/admin/default/build',
        'package_assets_directory' => 'src/Resources/assets',
    ],
],
```

### Step 3: Loading Assets in Layout

Use `@rehlaVite` instead of standard `@vite` or the old `@bagistoVite`:

```blade
<head>
    ...
    @rehlaVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'], 'admin')
</head>
```

### Development Commands

```bash
# Navigate to package
cd packages/rehla/dashboard

# Install dependencies
npm install

# Start dev server with hot reload
npm run dev

# Build for production
npm run build
```
