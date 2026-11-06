import { defineConfig, devices } from '@playwright/test';

if (!process.env.DB_DATABASE) {
    throw new Error('Run browser tests with npm run test:e2e to use an isolated database.');
}

export default defineConfig({
    testDir: './tests/e2e',
    fullyParallel: false,
    use: {
        baseURL: 'http://127.0.0.1:8123',
        ...devices['Desktop Chrome'],
    },
    webServer: {
        command: 'php artisan serve --host=127.0.0.1 --port=8123',
        url: 'http://127.0.0.1:8123',
        reuseExistingServer: false,
        timeout: 60_000,
    },
});
