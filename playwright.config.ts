import { defineConfig } from '@playwright/test';

export default defineConfig({
    testDir: './tests/e2e',
    retries: process.env.CI ? 1 : 0,
    use: {
        baseURL: 'http://127.0.0.1:8000',
        trace: 'on-first-retry',
    },
    webServer: {
        command: 'npm run build && php artisan serve --env=testing --host=127.0.0.1 --port=8000',
        env: {
            APP_ENV: 'testing',
            SESSION_DRIVER: 'array',
        },
        url: 'http://127.0.0.1:8000/up',
        reuseExistingServer: !process.env.CI,
        timeout: 120_000,
    },
    projects: [
        {
            name: 'chromium',
            use: { browserName: 'chromium' },
        },
    ],
});
