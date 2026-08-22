# Rehla Platform — Superpowers Architectural Design Spec
## مشروع «رحلة» — منصة بيع وإدارة خدمات تأشيرة العمرة

> **الحالة:** Design approved in chat on 2026-08-22. This document is the written-spec review copy required by the Superpowers architectural workflow.
>
> **يحل محل:** `خطة-مشروع-رحلة-PHP-v3-Bagisto-Aligned.md` كمرجع معماري رئيسي بعد اعتماد منهج Superpowers.
>
> **المصادر التي بُني عليها التصميم:** خطة Rehla v2/v3، والتحليل الكامل لحزمة Bagisto Admin المرفقة في `admin.txt`.

---

# 1. الهدف

بناء منصة Rehla على Laravel/PHP كبنية Modular Packages واضحة الحدود، مع لوحة إدارة تتبع **تنظيم Bagisto Admin وتجربة استخدامه المعمارية** دون نسخ خصائص التجارة الإلكترونية غير المطلوبة، ومع إبقاء Business Logic داخل Domain Packages وليس داخل لوحة الإدارة.

نجاح التصميم يعني أن:

1. كل حزمة لها مسؤولية واحدة مفهومة وحدود ثابتة.
2. لا توجد Circular Dependencies.
3. `rehla/core` لا يتحول إلى dumping ground.
4. `Checkout`, `CartRule`, `DataGrid`, `Rule`, `Media`, `ImageCache` وحدات مستقلة.
5. `rehla/dashboard` Admin Application/Presentation Layer كاملة مثل نمط Bagisto Admin.
6. Flutter يستهلك `rehla/api` ولا يعتمد على Admin Controllers.
7. مستندات الجواز/الهوية خاصة ولا تمر عبر public image cache.
8. كل Feature تُنفذ TDD: RED → GREEN → REFACTOR → VERIFY.
9. كل Milestone لها Gate واختبارات قبول قبل الانتقال لما بعدها.

---

# 2. النطاق

## 2.1 داخل V1

- Admin users / roles / ACL / 2FA.
- Customers.
- Service catalog + categories + service components.
- Cart and checkout.
- Promotions: Cart Rules + coupons.
- Sales orders and lifecycle.
- Payment records and payment workflow abstraction.
- Visa applications, applicants, passport data, documents, processing status.
- Notifications.
- Audit log.
- Secure media + public image cache.
- Admin dashboard and reporting essentials.
- Flutter API v1.
- System configuration.
- Admin cache management بWhitelist آمن.
- Pest package/feature tests.
- Playwright critical Admin E2E.
- API documentation.
- Production operations baseline.

## 2.2 خارج V1 عمداً

- Shipping.
- RMA.
- Wishlist / Compare / Reviews.
- Multi-channel.
- Multi-warehouse inventory.
- Marketplace plugin model proxy.
- ElasticSearch.
- Exchange-rate automation.
- Social login/share.
- Magic AI.
- Full-page cache.
- CatalogRule unless a real pricing requirement appears.
- Tax engine unless tax calculation becomes an explicit requirement.
- CMS unless editable Terms/Privacy/FAQ are explicitly required.
- Bulk import/export unless operationally required.

**YAGNI rule:** لا تُضاف حزمة أو abstraction لأنها موجودة في Bagisto؛ تُضاف فقط إذا كان لها Requirement حقيقي في Rehla.

---

# 3. القرارات التقنية المعتمدة

| الجانب | القرار |
|---|---|
| Backend | Laravel 13 |
| PHP | PHP 8.3+ |
| Database | PostgreSQL |
| ORM | Eloquent |
| Mobile | Flutter |
| Mobile Auth | Laravel Sanctum |
| Admin Auth | Session Guard مستقل `admin` |
| Admin RBAC | `spatie/laravel-permission` + ACL hierarchy في Core |
| Admin UI | Blade + Tailwind CSS + Alpine.js + Vite |
| Files | Laravel Filesystem مع Public/Private separation |
| Image processing | `rehla/image-cache` فوق Media UUIDs + preset whitelist |
| Queue | Laravel Queue؛ Redis عند الحاجة في بيئة الإنتاج |
| Testing | Pest + Orchestra Testbench + Playwright |
| API docs | Scribe/OpenAPI |
| Deployment | Nginx + PHP-FPM + Supervisor + Scheduler؛ بدون Docker كشرط تشغيل |

---

# 4. المبادئ المعمارية

## 4.1 Domain owns business rules

الـModels, Repositories, Domain Services, State Machines, Value Objects وقواعد الأعمال تعيش في الحزمة المالكة للمجال.

مثال:

```text
Dashboard OrderController
        ↓
Sales OrderService / OrderRepository
        ↓
Sales Models / State Machine
```

ولا يوضع `Order` model داخل Dashboard.

## 4.2 Presentation may depend on domains

`rehla/dashboard` و`rehla/api` حزم Presentation/Application، لذلك مسموح لهما الاعتماد على Domain Packages التي تعرضانها.

هذا مقصود ومتوافق مع نمط Bagisto Admin الفعلي.

## 4.3 Core is business-agnostic

Core لا يعرف Product أو Order أو Payment أو VisaApplication.

Core يملك فقط primitives مشتركة مثل:

- ACL engine.
- Menu engine.
- SystemConfig engine.
- Locale/Currency reference data.
- Base exceptions.
- shared security middleware.
- common validation primitives.
- event infrastructure.
- package-independent helpers.

## 4.4 No circular dependencies

الاعتماديات يجب أن تكون DAG. يتم فحصها في CI.

## 4.5 Contracts live with the consumer/owner

لا ننقل Business Contracts إلى Core لمجرد إعادة الاستخدام.

مثال: Contract لإنشاء Order يملكه `sales`، وليس `core`.

## 4.6 Events for asynchronous side effects

Notifications وAudit وعمليات غير حرجة للاستجابة الفورية تُربط بالأحداث حين تكون Eventual Consistency مقبولة.

أما Checkout/Payment critical transitions فلا تعتمد على asynchronous event وحده لإتمام invariants أساسية.

---

# 5. خريطة الحزم V1

## Foundation

1. `rehla/core`
2. `rehla/datagrid`
3. `rehla/rule`
4. `rehla/media`
5. `rehla/image-cache`

## Business Domains

6. `rehla/customers`
7. `rehla/admin-users`
8. `rehla/catalog`
9. `rehla/cart-rule`
10. `rehla/sales`
11. `rehla/payment`
12. `rehla/checkout`
13. `rehla/applications`

## Supporting Domains

14. `rehla/notifications`
15. `rehla/audit-log`

## Presentation

16. `rehla/dashboard`
17. `rehla/api`

---

# 6. Dependency DAG

```text
rehla/core
├── rehla/datagrid
├── rehla/rule
├── rehla/media
│   └── rehla/image-cache
├── rehla/customers
├── rehla/admin-users
└── rehla/catalog

rehla/cart-rule
├── rehla/core
├── rehla/rule
├── rehla/catalog
└── rehla/customers

rehla/sales
├── rehla/core
├── rehla/catalog
└── rehla/customers

rehla/payment
├── rehla/core
├── rehla/sales
└── rehla/media

rehla/checkout
├── rehla/core
├── rehla/catalog
├── rehla/customers
├── rehla/cart-rule
├── rehla/sales
└── rehla/payment

rehla/applications
├── rehla/core
├── rehla/sales
├── rehla/customers
└── rehla/media

rehla/notifications
└── rehla/core + subscribed domain events

rehla/audit-log
└── rehla/core + subscribed domain events

rehla/dashboard
├── rehla/core
├── rehla/datagrid
├── rehla/catalog
├── rehla/customers
├── rehla/admin-users
├── rehla/cart-rule
├── rehla/sales
├── rehla/payment
├── rehla/checkout
├── rehla/applications
├── rehla/media
├── rehla/image-cache
└── rehla/audit-log

rehla/api
├── rehla/core
├── rehla/catalog
├── rehla/customers
├── rehla/cart-rule
├── rehla/checkout
├── rehla/sales
├── rehla/payment
└── rehla/applications
```

## 6.1 حل اعتماد CartRule/Checkout

`rehla/cart-rule` **لا تعتمد على `rehla/checkout`**.

بدلاً من ذلك، تملك CartRule DTO باسم مثل:

```text
CartRuleContext
├── customerId
├── customerSegment
├── items[]
│   ├── productId
│   ├── categoryIds
│   ├── quantity
│   └── unitPrice
├── subtotal
└── appliedCouponCode
```

`rehla/checkout` تبني هذا الـContext من Cart الخاصة بها ثم تستدعي CartRule evaluator.

بهذا تصبح العلاقة أحادية الاتجاه:

```text
Checkout → CartRule → Rule
```

ولا توجد دورة اعتماد.

---

# 7. `rehla/core`

## 7.1 المسؤوليات

- ACL tree and permission mapping.
- Menu tree primitives.
- SystemConfig registry and value access.
- Locale / Currency reference data.
- secure common middleware.
- package-neutral exceptions.
- common validation rules.
- event primitives.
- safe helper utilities.

## 7.2 ممنوع داخل Core

- Product pricing logic.
- Order lookup logic.
- Cart logic.
- Payment logic.
- Visa application logic.
- DataGrid engine.
- Rule engine.
- Image transformation.

## 7.3 Acceptance Criteria

- Core imports no Rehla business package namespace.
- ACL tree supports nested keys and route mapping.
- Menu engine filters by permission.
- SystemConfig supports typed fields and locale-aware values.
- Package tests pass standalone via Testbench.

---

# 8. `rehla/datagrid`

## 8.1 المسؤوليات

- Query processing.
- Columns.
- Sort allowlist.
- Filters.
- Search.
- Pagination.
- Row actions.
- Mass actions.
- Saved filters contracts.
- Export contracts.
- Serialization metadata for Admin UI.

## 8.2 Security invariants

- لا يقبل raw SQL column من request.
- sort/filter columns يجب أن تكون معرفة مسبقاً في DataGrid definition.
- لا يوجد arbitrary class execution endpoint.
- Saved filters مرتبطة بمالكها.

## 8.3 Acceptance Criteria

- SQL injection attempts through sort/filter names are rejected.
- Pagination/search/filter tests pass.
- Mass actions enforce ACL supplied by the Admin layer.

---

# 9. `rehla/rule`

محرك عام لا يعرف Cart.

## 9.1 Concepts

- `Rule`
- `Condition`
- `ConditionGroup`
- `Operator`
- `RuleContext`
- `RuleResult`
- `Evaluator`

يدعم `all` / `any` nested groups، operators محددة بRegistry، fail-closed invalid operators.

## 9.2 Acceptance Criteria

- Nested conditions deterministic.
- Unknown operator rejected.
- Date boundaries tested.
- No dependency on checkout/cart-rule.

---

# 10. `rehla/media`

## 10.1 التصنيف

### Public Media

- service images.
- logos.
- harmless admin/public assets.

### Private Documents

- passport scans.
- identity documents.
- visa-related attachments.
- private payment evidence where applicable.

## 10.2 Security

- private disk خارج public web root.
- authorization before download.
- no permanent public URL for private documents.
- MIME detection server-side.
- deny executable extensions.
- random/UUID identifiers.
- audit access to highly sensitive documents when required.
- malware-scan hook available.

---

# 11. `rehla/image-cache`

تعمل على Public Media فقط في V1.

## 11.1 Input contract

```text
media UUID + preset key
```

وليس filesystem path.

## 11.2 Presets

Preset registry صريح مثل:

```text
service-thumb
service-card
service-detail
admin-thumb
```

## 11.3 Security invariants

- no raw paths.
- no `../` traversal.
- canonical storage resolution.
- preset whitelist.
- cache key includes original content hash/version.
- invalidation on media replace/delete.

---

# 12. `rehla/customers`

- Customer account.
- profile.
- verified contacts as required.
- customer status.
- customer addresses/identity metadata only if actually needed by business flow.

لا يملك Admin UI؛ Dashboard تعرضه.

---

# 13. `rehla/admin-users`

- Admin model.
- role/permission persistence through spatie.
- role assignment policies.
- permission synchronization command from Dashboard ACL configuration.
- 2FA secret/recovery-code storage support.

Admin screens/controllers remain in Dashboard.

---

# 14. `rehla/catalog`

## 14.1 Domain

- categories.
- services/products.
- product images references.
- service components/options required for visa service composition.
- price definitions.
- activation/visibility.

## 14.2 Rules

- catalog owns canonical prices.
- Checkout never trusts mobile-submitted price.
- slug uniqueness enforced at DB/application boundary.

---

# 15. `rehla/cart-rule`

## 15.1 Domain

- CartRule.
- Coupon.
- conditions.
- actions.
- active windows.
- priorities.
- stop-processing behavior.
- usage limits.
- per-customer usage if required.

## 15.2 Integration

Receives `CartRuleContext`; returns `DiscountResult`.

Checkout owns application to totals.

## 15.3 Concurrency

Coupon usage increment is atomic/locked within final checkout transaction or equivalent safe mechanism.

---

# 16. `rehla/sales`

Sales يبدأ **بعد** إنشاء order.

## 16.1 Domain

- Order.
- OrderItem.
- status/state machine.
- status history.
- admin notes/comments.
- cancellation rules.
- immutable financial snapshots needed for historical accuracy.

## 16.2 Separation

Sales does not own Cart, coupon evaluation or checkout orchestration.

---

# 17. `rehla/payment`

## 17.1 Domain

- payment methods abstraction.
- payment record/attempt/reference.
- payment state.
- reconciliation hooks.
- evidence/receipt attachment reference where applicable.

## 17.2 Invariants

- provider references unique where applicable.
- money uses fixed decimal/minor-unit strategy; never float.
- payment status independent from order/application status.
- webhook/retry processing idempotent if provider integration is added.

---

# 18. `rehla/checkout`

Checkout هو application/domain orchestrator للشراء.

## 18.1 Domain

- Cart.
- CartItem.
- CheckoutContext.
- cart validation.
- server-side pricing resolution.
- totals pipeline.
- promotion evaluation through CartRule.
- payment-method eligibility.
- idempotency.
- transaction boundary.
- order creation through Sales service/contract.

## 18.2 Totals pipeline

```text
Resolve canonical prices
  ↓
Validate cart
  ↓
Subtotal
  ↓
Build CartRuleContext
  ↓
Apply discounts
  ↓
Fees/other approved collectors
  ↓
Grand total
  ↓
Payment selection validation
  ↓
Transactional finalize
  ↓
Create Order snapshot
```

## 18.3 Critical invariants

- client cannot set authoritative prices.
- duplicate idempotency key returns/reuses same logical result.
- failed checkout rolls back all critical writes.
- promotion usage update and order creation stay transactionally safe.
- stale/inactive catalog item blocks checkout with explicit error.

---

# 19. `rehla/applications`

هذه الحزمة تمثل رحلة معالجة التأشيرة ولا تُختزل في Sales Order.

## 19.1 Domain

- VisaApplication.
- Applicant.
- PassportData.
- ApplicationDocument reference.
- ApplicationStatus.
- Review/notes.
- processing history.

## 19.2 Relationship

```text
Order
 └── VisaApplication
      ├── Applicant(s)
      ├── PassportData
      └── Private Documents
```

## 19.3 Invariants

- Application status independent from Order and Payment status.
- private documents go through Media authorization.
- status transitions are explicit and audited.

---

# 20. `rehla/notifications`

- queued notification dispatch.
- channels actually required by product (email/push first; others only by requirement).
- listens to domain events.
- failures do not corrupt checkout/order transaction.
- retry/failure tracking.

---

# 21. `rehla/audit-log`

Audits privileged/critical operations such as:

- role/permission changes.
- configuration changes.
- cache execution.
- payment review changes.
- application status transitions.
- sensitive document administrative access when policy requires it.

Audit writes should not silently disappear; failures are observable.

---

# 22. `rehla/api`

Flutter Presentation Package.

## 22.1 Structure

```text
rehla/api/
└── src/
    ├── Http/
    │   ├── Controllers/V1/
    │   ├── Requests/V1/
    │   ├── Resources/V1/
    │   └── Middleware/
    ├── Routes/api.php
    └── Providers/ApiServiceProvider.php
```

## 22.2 Rules

- versioned routes `/api/v1`.
- API Resources; never raw Eloquent models.
- validation through Requests.
- Sanctum auth.
- rate limiting.
- idempotency support for checkout/payment-changing endpoints.
- domain services reused; no duplicate business logic.

---

# 23. `rehla/dashboard` — Bagisto-aligned Admin Application

## 23.1 Ownership

Dashboard owns:

- Admin routes.
- Admin controllers.
- Admin form requests.
- Admin JSON resources used by its AJAX UI.
- Admin DataGrid definitions.
- Admin views.
- reusable Admin components.
- dashboard/reporting helpers.
- admin auth screens.
- configuration UI.
- cache-management UI/service adapter.
- centralized Admin `menu.php` and `acl.php`.

Dashboard does **not** own business models/repositories.

## 23.2 Package tree

```text
packages/rehla/dashboard/
├── composer.json
├── package.json
├── postcss.config.cjs
├── tailwind.config.js
├── vite.config.js
├── src/
│   ├── Config/
│   │   ├── acl.php
│   │   ├── menu.php
│   │   └── system.php
│   ├── DataGrids/
│   │   ├── Catalog/
│   │   ├── Customers/
│   │   ├── Marketing/Promotions/
│   │   ├── Sales/
│   │   ├── Payments/
│   │   ├── Applications/
│   │   └── Settings/
│   ├── Exports/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Listeners/
│   ├── Mail/
│   ├── Providers/
│   ├── Services/
│   ├── Validations/
│   ├── Resources/
│   │   ├── assets/
│   │   ├── lang/ar/
│   │   ├── lang/en/
│   │   └── views/
│   └── Routes/
└── tests/
    ├── Feature/
    └── e2e-pw/
```

## 23.3 Routes composition

```text
auth-routes.php
sales-routes.php
application-routes.php
payment-routes.php
catalog-routes.php
customers-routes.php
marketing-routes.php
reporting-routes.php
settings-routes.php
configuration-routes.php
notification-routes.php
```

All protected groups use:

- admin authentication.
- ACL middleware.
- NoCache middleware where appropriate.

## 23.4 DataGrid pattern

Domain Admin controller owns invocation:

```php
public function index()
{
    if (request()->ajax()) {
        return datagrid(OrderDataGrid::class)->process();
    }

    return view('admin::sales.orders.index');
}
```

Shared DataGrid controller may only expose safe infrastructure endpoints like lookup and saved filters.

## 23.5 Admin UI component library

V1 component set:

- layout / anonymous layout.
- header.
- collapsible sidebar.
- button.
- form/control-group/label/control/error.
- select/multiselect.
- datagrid.
- toolbar/search/filter/pagination/mass-actions.
- saved filters.
- modal/confirm modal.
- drawer.
- dropdown.
- tabs.
- accordion.
- date/datetime/time picker.
- media picker/uploader.
- flash/toast.
- badge.
- shimmer/skeleton.
- charts.
- empty state.

## 23.6 UX baseline

- Arabic RTL first-class.
- English LTR.
- dark mode through class.
- responsive desktop/tablet; mobile admin usable for basic operations but desktop is primary.
- consistent spacing/type/status badges.
- sidebar generated from centralized menu config and permission-filtered.

## 23.7 Auth flow

- login/logout.
- forgot password.
- reset password.
- account/profile.
- 2FA setup/verify/disable.
- recovery codes.
- login throttling.
- session regeneration.

## 23.8 Cache management

User selects predefined action key only.

Allowed examples:

- clear-all.
- clear-config.
- clear-cache.
- clear-routes.
- clear-views.
- build-config.
- build-routes.
- build-views.

No arbitrary Artisan command or shell argument.

Super Admin permission required and every execution audited.

---

# 24. ACL and Menu

## 24.1 Source of truth

For V1 Admin experience:

```text
rehla/dashboard/src/Config/acl.php
rehla/dashboard/src/Config/menu.php
```

This intentionally mirrors the Bagisto Admin pattern discovered in the supplied source.

## 24.2 Permission storage

`spatie/laravel-permission` persists permissions/roles.

A deterministic sync command reads ACL keys and reconciles missing permissions.

## 24.3 Fail-closed rule

Protected Admin route without ACL mapping fails CI and is not accepted into release.

---

# 25. SystemConfig

`rehla/core` owns engine and values.

Dashboard owns configuration UI.

SystemConfig is for configuration values such as:

- platform branding.
- support contact values.
- checkout timeout/limits.
- image processing defaults.
- notification configuration flags.

It is **not** a replacement for CRUD entities such as Users/Roles/Banks/Services.

Secrets are encrypted where applicable and never re-rendered in plaintext after save.

---

# 26. Database ownership map

## Core

- `languages`
- `currencies`
- `core_config`

## Admin Users

- `admin_users`
- spatie permission/role tables
- 2FA/recovery storage fields/tables according to chosen implementation

## Customers

- `customers`
- supporting customer tables only when required

## Media

- `media`

## Catalog

- `categories`
- `products` / `services` (final naming decided once and used consistently)
- `product_images`
- `service_components`
- `product_service_components`

## Checkout

- `carts`
- `cart_items`
- idempotency records if persisted centrally

## CartRule

- `cart_rules`
- `cart_rule_coupons`
- `cart_rule_usages`

## Sales

- `orders`
- `order_items`
- `order_status_history`
- `order_comments` if included in V1

## Payment

- `payments`
- `payment_attempts` if multiple attempts are supported

## Applications

- `visa_applications`
- `applicants`
- `passport_data`
- `application_documents`
- `application_status_history`

## Notifications

- Laravel notifications/jobs tables as required

## Audit

- `audit_logs`

---

# 27. Critical data flows

## 27.1 Checkout flow

```text
Flutter/API request
  ↓
API Request validation
  ↓
Checkout service
  ↓
Resolve customer + cart
  ↓
Catalog canonical prices
  ↓
Cart validation
  ↓
Build CartRuleContext
  ↓
CartRule evaluation
  ↓
Totals
  ↓
Payment eligibility
  ↓
DB transaction
  ├── lock/revalidate coupon usage
  ├── create Order snapshot in Sales
  ├── create Payment record/intent if required
  └── consume/finalize Cart
  ↓
Return stable API Resource
```

## 27.2 Visa application flow

```text
Paid/eligible Order
  ↓
Application creation
  ↓
Applicant data
  ↓
Private document upload through Media
  ↓
Admin review
  ↓
Explicit status transition
  ↓
Audit + notification event
```

## 27.3 Admin list flow

```text
Admin route
  ↓
auth + ACL
  ↓
Dashboard Controller
  ↓
Dashboard DataGrid definition
  ↓
DataGrid engine
  ↓
Domain Repository/Query
  ↓
JSON metadata/data
  ↓
Blade + Alpine DataGrid component
```

---

# 28. Error handling

## API

Standard envelope with stable machine-readable code, localized message, field errors, request ID where available.

Suggested categories:

- validation error → 422.
- unauthenticated → 401.
- forbidden → 403.
- not found → 404.
- conflict/state violation → 409.
- rate limited → 429.
- unexpected server error → 500 with no sensitive detail.

## Admin

- form validation errors inline.
- destructive/state-changing failures visible as explicit toast/banner.
- no swallowed exceptions.
- privileged failures logged with request/user context.

## Domain

Domain exceptions are typed and translated at Presentation boundary; domains do not return HTTP responses.

---

# 29. Security baseline

## Admin

- CSRF.
- session regeneration.
- login throttling.
- strong password policy.
- 2FA for privileged roles.
- fail-closed ACL.
- audit privileged changes.
- no arbitrary Artisan execution.
- no arbitrary DataGrid class execution.

## DataGrid

- sort/filter allowlist.
- no raw SQL from query params.
- ownership checks for saved filters.

## Media

- private disk.
- authorization.
- MIME validation.
- signed/controlled download.
- no sensitive file names/content in logs.

## ImageCache

- UUID + preset only.
- no raw path.
- path traversal tests.

## Checkout/Payment

- authoritative server-side prices.
- DB transaction.
- idempotency.
- no float money.
- coupon concurrency safety.
- unique external refs.

## Configuration

- typed validation.
- secret encryption/masking.
- audited mutation.

---

# 30. Testing strategy

## 30.1 Test pyramid

1. Unit tests for pure domain/rule calculations.
2. Package feature tests with Testbench.
3. Application feature tests for API/Admin boundaries.
4. Playwright only for critical Admin journeys and shared component behavior.

## 30.2 Architecture tests

Required CI checks:

- no circular package dependencies.
- Core imports no business package.
- Domain packages import no Dashboard/API.
- Dashboard contains no business Models.
- API does not expose raw Eloquent Models.
- all protected Admin routes mapped to ACL.

## 30.3 Security regression tests

- DataGrid malicious sort/filter keys.
- ImageCache traversal/raw-path attempts.
- private media unauthorized access.
- duplicate checkout idempotency key.
- concurrent coupon use.
- unauthorized cache-management action.
- privilege escalation attempts.

---

# 31. Superpowers implementation discipline

كل Feature Task تُكتب قبل التنفيذ بهذا الشكل:

```text
Task ID + goal
Files expected to change
Dependencies
RED tests
Minimum GREEN implementation
REFACTOR boundaries
VERIFY commands
Acceptance criteria
```

## Mandatory cycle

```text
RED
↓
GREEN
↓
REFACTOR
↓
VERIFY
```

لا تبدأ عدة Features غير مترابطة في Patch واحدة.

---

# 32. Milestones and gates

> المدد ليست Gate. الانتقال يتم فقط عند تحقق Acceptance Gate.

## M0 — Architecture baseline and skeleton

### Goal

إنشاء Laravel application skeleton + package workspace + CI architecture checks.

### Tasks

- root composer path repositories.
- package naming/autoload convention.
- explicit first-party provider order.
- common Pest/Testbench setup.
- architecture dependency scanner/test.
- CI baseline.

### Gate M0

- application boots.
- every placeholder package can be discovered explicitly.
- dependency graph test passes.
- Core has no business imports.
- CI green.

---

## M1 — Core kernel

### Tasks

- ACL engine.
- Menu engine.
- SystemConfig engine/storage.
- Locale/Currency reference data.
- shared middleware/exceptions.

### Gate M1

- ACL/Menu/SystemConfig package tests green.
- locale-aware config uniqueness tested.
- no business logic in Core.

---

## M2 — DataGrid + Rule infrastructure

### Tasks

- DataGrid engine primitives.
- sort/filter/search/pagination.
- saved-filter contracts.
- Rule engine + nested conditions/operators.

### Gate M2

- DataGrid malicious-column tests green.
- nested rule tests green.
- no arbitrary DataGrid class route exists.

---

## M3 — Media + ImageCache

### Tasks

- Media model/repository/service.
- public/private disks.
- secure download authorization.
- image presets/cache/invalidation.

### Gate M3

- unauthorized private document access blocked.
- traversal tests green.
- only public media reaches ImageCache.

---

## M4 — Dashboard foundation + Admin Auth

### Tasks

- Dashboard provider/routes/assets.
- layout/header/sidebar.
- common components.
- DataGrid UI.
- login/logout/reset/account.
- 2FA/recovery.
- centralized ACL/menu.

### Gate M4

- auth/2FA feature tests green.
- sidebar ACL behavior green.
- RTL/dark-mode smoke tests green.
- DataGrid Playwright smoke journey green.

---

## M5 — Admin Users + Customers

### Tasks

- Admin User/Role domain persistence.
- ACL permission sync command.
- Admin user/role screens.
- Customer domain + Admin DataGrid/detail.
- Customer API basics.

### Gate M5

- no protected admin route lacks ACL mapping.
- role change audited.
- customer CRUD/query tests green.

---

## M6 — Catalog

### Tasks

- category domain.
- service/product domain.
- service components.
- public/admin image references.
- Dashboard CRUD/DataGrids.
- API resources.

### Gate M6

- canonical price cannot be client-overridden.
- duplicate slug rejected.
- inactive items hidden/rejected according to contract.
- Admin and API critical tests green.

---

## M7 — CartRule

### Tasks

- rule persistence.
- coupon persistence.
- CartRuleContext/DiscountResult.
- fixed/percentage discount.
- active windows/priority/usage.

### Gate M7

- nested conditions green.
- priority/stop behavior green.
- concurrent usage test green.
- no dependency on Checkout package.

---

## M8 — Sales + Payment foundation

### Tasks

- Order/OrderItem.
- order state machine/history.
- payment records/states.
- payment eligibility/contracts.
- Admin order/payment screens.

### Gate M8

- illegal order transition rejected.
- money strategy consistent and no floats.
- payment status separate from order status.
- key transitions audited.

---

## M9 — Checkout

### Tasks

- Cart/CartItem.
- cart validation.
- server-side pricing.
- totals pipeline.
- CartRule integration.
- payment method validation.
- idempotent finalize.
- transactionally create Order/Payment.

### Gate M9

- price tampering test green.
- stale cart test green.
- duplicate idempotency test green.
- checkout rollback test green.
- coupon usage + order creation concurrency-safe.

---

## M10 — Visa Applications

### Tasks

- VisaApplication.
- Applicant.
- PassportData.
- ApplicationDocument relation to Media.
- state transitions/history.
- Admin processing screens.
- API endpoints needed by Flutter.

### Gate M10

- unauthorized document download blocked.
- illegal application transition rejected.
- order/payment/application statuses remain independent.
- application critical journey Playwright green.

---

## M11 — Notifications + Audit

### Tasks

- notification events/listeners/jobs.
- audit subscribers/services.
- failure/retry visibility.

### Gate M11

- notification failure does not corrupt business transaction.
- privileged actions have audit coverage.
- failed jobs observable.

---

## M12 — Dashboard completion + Reporting + Configuration

### Tasks

- KPI/dashboard helpers.
- essential reports only.
- SystemConfig UI.
- cache-management UI.
- final reusable components.

### Gate M12

- configuration validation/audit green.
- cache whitelist authorization green.
- report queries permission-scoped where required.

---

## M13 — API v1 completion

### Tasks

- final versioned routes.
- Resources/Requests.
- rate limits.
- API error contract.
- API docs.

### Gate M13

- OpenAPI/Scribe build green.
- no raw Eloquent model exposure.
- auth/rate-limit/validation contract tests green.

---

## M14 — Hardening and regression

### Tasks

- security regression suite.
- performance/query review.
- N+1 review critical screens.
- queue failure scenarios.
- backup/restore documentation.
- full Admin E2E critical journeys.

### Gate M14

- all security tests green.
- full test suite green.
- no known P1/P2 defects.
- backup restore drill succeeds in staging-like environment.

---

## M15 — UAT and Production release

### Tasks

- release checklist.
- DB backup.
- migration dry run.
- production deploy.
- smoke tests.
- rollback proof.

### Gate M15

- UAT sign-off.
- production smoke tests green.
- queue/scheduler healthy.
- rollback procedure verified.

---

# 33. Task template example

## CAT-04 — Create service/product

### Goal

إنشاء خدمة Catalog جديدة من Admin مع validation وسعر canonical وصورة عامة اختيارية.

### Expected files

```text
packages/rehla/catalog/src/Models/Product.php
packages/rehla/catalog/src/Repositories/ProductRepository.php
packages/rehla/catalog/src/Services/ProductService.php
packages/rehla/dashboard/src/Http/Controllers/Catalog/ProductController.php
packages/rehla/dashboard/src/Http/Requests/ProductForm.php
packages/rehla/dashboard/src/DataGrids/Catalog/ProductDataGrid.php
packages/rehla/dashboard/src/Resources/views/catalog/products/*
packages/rehla/catalog/tests/*
packages/rehla/dashboard/tests/Feature/Catalog/*
```

### RED

- create without required category → rejected.
- invalid price → rejected.
- duplicate slug → rejected.
- unauthorized admin → 403.

### GREEN

Implement minimum domain/repository/controller code required to satisfy tests.

### REFACTOR

- keep validation in Request/domain rule as appropriate.
- no direct Eloquent manipulation from Dashboard controller beyond repository/service contract.

### VERIFY

- package tests.
- Dashboard feature tests.
- formatter/static analysis.
- targeted Playwright create/edit smoke if UI changed materially.

### Acceptance criteria

- created item appears in Admin DataGrid.
- API returns canonical price.
- ACL enforced.
- audit event emitted for privileged mutation if policy includes Catalog changes.

---

# 34. Definition of Done

A task/milestone is not done because code was written.

Required where applicable:

- [ ] Acceptance criteria pass.
- [ ] RED tests existed before implementation.
- [ ] Targeted Pest tests pass.
- [ ] Architecture tests pass.
- [ ] Formatter/static analysis pass.
- [ ] No new package boundary violation.
- [ ] Migration rollback or forward-safe strategy tested.
- [ ] ACL mapping added and tested for new Admin routes.
- [ ] API contract documented for new/changed external endpoints.
- [ ] Sensitive data not exposed in logs/responses.
- [ ] Relevant Playwright journey passes for critical Admin UI changes.
- [ ] No unresolved P1/P2 bug introduced.
- [ ] Verification evidence captured before merge/release claim.

---

# 35. Provider registration

First-party providers are explicitly ordered; Composer `require` order is not treated as boot-order guarantee.

Suggested sequence:

```text
Core
DataGrid
Rule
Media
ImageCache
Customers
AdminUsers
Catalog
CartRule
Sales
Payment
Checkout
Applications
Notifications
AuditLog
Dashboard
Api
```

---

# 36. Operational baseline

- health endpoint.
- queue Supervisor.
- scheduler every minute.
- failed job monitoring.
- structured logs with request ID.
- no passport/document payloads in logs.
- DB backup policy.
- media backup policy.
- restore drill before production.
- storage free-space monitoring.
- application version/commit visible to authorized Admin only.

---

# 37. Risks and mitigations

| Risk | Mitigation |
|---|---|
| Core grows uncontrollably | Business-agnostic import rule + architecture test |
| Dashboard absorbs domain logic | Dashboard may depend on domains but cannot own business Models/Repositories |
| Checkout/CartRule cycle | CartRuleContext owned by CartRule; only Checkout → CartRule |
| Price tampering | canonical Catalog resolution server-side |
| Coupon race | atomic/locked usage during finalize |
| Duplicate checkout | idempotency key + transactional finalize |
| Sensitive document leak | private disk + authorization + no ImageCache |
| Image path traversal | UUID + preset whitelist + traversal regression tests |
| DataGrid injection | column allowlists + no arbitrary class endpoint |
| ACL gaps | CI route-to-ACL coverage gate |
| Admin complexity | shared component library + Playwright critical journeys |
| Over-building Bagisto features | explicit V1 out-of-scope + YAGNI gate |

---

# 38. Estimated sequencing

Superpowers treats estimates as planning aids, not completion criteria.

For one experienced full-stack Laravel developer, the architectural scope remains roughly **12–14 weeks** if requirements stay stable. Two developers working on independent tasks may reduce calendar time, but security/testing gates must not be skipped.

The implementation plan created after this spec is approved will break each Milestone into 2–10 minute atomic engineering steps where practical, with exact files and test commands.

---

# 39. Spec self-review result

This written spec was checked for:

- placeholders/TBDs: none required for architectural execution.
- dependency contradictions: CartRule/Checkout cycle removed.
- scope creep: Bagisto-only commerce features remain explicitly out of V1.
- ambiguous package ownership: Dashboard/Domain/API boundaries explicitly defined.
- testing ambiguity: milestone gates and TDD cycle defined.
- security ambiguity: private documents, DataGrid, ImageCache, Checkout and ACL have explicit invariants.

No implementation code is authorized by this spec alone. The next Superpowers step, after user review/approval of this written spec, is `writing-plans` to produce the detailed implementation plan.
