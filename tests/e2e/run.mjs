import { mkdtempSync, rmdirSync, unlinkSync, writeFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { spawnSync } from 'node:child_process';

const directory = mkdtempSync(join(tmpdir(), 'villa-esmeralda-e2e-'));
const database = join(directory, 'database.sqlite');
writeFileSync(database, '');

const env = {
    ...process.env,
    APP_ENV: 'testing',
    DB_CONNECTION: 'sqlite',
    DB_DATABASE: database,
    DB_URL: '',
    SESSION_DRIVER: 'database',
    CACHE_STORE: 'array',
    QUEUE_CONNECTION: 'sync',
};

try {
    const migrate = spawnSync('php artisan migrate --force --no-interaction', {
        shell: true, stdio: 'inherit', env,
    });
    if (migrate.status !== 0) {
        throw new Error(`Test database migration failed: ${migrate.error?.message ?? migrate.status}`);
    }

    const tests = spawnSync('npx playwright test', {
        shell: true, stdio: 'inherit', env,
    });
    if (tests.error) {
        throw tests.error;
    }
    process.exitCode = tests.status ?? 1;
} finally {
    unlinkSync(database);
    rmdirSync(directory);
}
