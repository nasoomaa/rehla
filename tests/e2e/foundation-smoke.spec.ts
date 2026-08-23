import { expect, test } from '@playwright/test';

test('Laravel test application is healthy', async ({ request }) => {
    const response = await request.get('/up');
    expect(response.status()).toBe(200);
});

test('compiled Alpine entrypoint initializes', async ({ page }) => {
    await page.goto('/_foundation/smoke');
    await expect(page.locator('[data-foundation-status]')).toHaveText('ready');
});
