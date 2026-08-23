# Foundation Gate Evidence

Recorded at (UTC): 2026-08-23T03:32:38Z
Revision: `2a627ef`

Observed versions: PHP 8.5.4; Composer 2.9.5; Laravel 13.26.1.

Database target: PostgreSQL (pgsql); database name and credentials redacted.

| Command | Exit status | Observed result |
| --- | ---: | --- |
| `php -v` | 0 | PHP 8.5.4 reported. |
| `composer --version` | 0 | Composer 2.9.5 reported. |
| `php artisan about --only=environment` | 0 | Laravel 13.26.1 reported; no pass/error count emitted. |
| `composer validate --strict` | 0 | Composer manifest valid. |
| `composer format:test` | 0 | Pint passed. |
| `composer analyse` | 0 | PHPStan passed; 0 errors. |
| `./vendor/bin/pest tests/Architecture` | 0 | 17 passed; 26 assertions. |
| `php artisan test` | 0 | 19 passed; 31 assertions. |
| `npm ci` | 0 | 111 packages added; 112 packages audited; 0 vulnerabilities. |
| `npm run build` | 0 | Vite production build completed warning-free; 4 modules transformed. |
| `npm run test:e2e -- tests/e2e/foundation-smoke.spec.ts` | 0 | 2 passed; 2 non-failing Node color-configuration warnings emitted. |
| `git diff --check` | 0 | No whitespace errors reported. |

## Limitations

The focused Playwright run emitted two non-failing Node color-configuration warnings.
