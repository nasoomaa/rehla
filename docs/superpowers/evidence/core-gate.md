# Rehla Core — Acceptance Gate Evidence

> **Execution Unit:** 01 / 19
> **Date:** 2026-08-23
> **Branch:** feat/rehla-core
> **Commit:** HEAD

## 1. Concrete Implementation Map

| Requirement | Implementation / Proof |
|---|---|
| Menu registry and menu item contracts | `MenuManager::register()/items()` implemented; interface bound in `CoreServiceProvider`. |
| ACL registry and ACL node contracts | `AclManager::register()/allows()` implemented; tests verify it fails closed. |
| SystemConfig registry/storage abstraction | `SystemConfigManager` and `DatabaseSystemConfigRepository` implemented. |
| locale infrastructure | `Locale` model and `locales` table migration created. |
| currency infrastructure | `Currency` model and `currencies` table migration created. |
| request/correlation IDs | `RequestId` and `EnsureRequestId` middleware implemented and tested. |
| shared exceptions/support | Standard framework exceptions used; `ProvidesCorePackage` extracted for test support. |
| core_config unique constraints | `core_config` table has `UNIQUE(key, locale_code)`. |
| Events and Secondary Reactions | `SystemConfigChanged` dispatched by `SystemConfigManager`. |

## 2. Gate Verification Results

### Package Tests (Focused)
- Command: `./vendor/bin/pest --testsuite=Package`
- Result: 19 tests passed (100% GREEN)

### Architecture Tests
- Command: `./vendor/bin/pest tests/Architecture`
- Result: 20 tests passed (100% GREEN)

### Security Invariants
- `CoreSecurityInvariantTest.php` proves ACL fails closed, secrets are redacted from array serialization, and Request IDs overwrite client headers.

### Excluded Responsibilities Check
- No Datagrid, Rule, Media, or business domains were leaked into `packages/rehla/core`.
- The `CoreBoundaryTest` enforces isolation.

## 3. Final Code State

The `composer validate` passes. Migrations successfully run in the `testing` environment. No placeholder logic remains.

**Conclusion:** The `rehla/core` package passes the completion gate and is ready for integration.
