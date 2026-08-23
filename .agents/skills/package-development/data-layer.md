# Data Layer — Migrations, Models, Repositories

## Migrations

### Creating Migrations

```bash
# Using Laravel artisan
php artisan make:migration CreateApplicationsTable --path=packages/rehla/applications/src/Database/Migrations
```

### Basic Migration Structure

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_applications');
    }
};
```

### Running Migrations

Migrations alter the database, so run them against your local or staging database — never straight
against production — and make sure the package's migrations are the only ones pending if you are
unsure what else is queued (`php artisan migrate:status` lists them first).

```bash
# Run all migrations
php artisan migrate

# Run specific package migrations
php artisan migrate --path=packages/rehla/applications/src/Database/Migrations

# Check migration status
php artisan migrate:status
```

## Models

### Rehla Model Architecture

Rehla uses a two-component model system (no Concord Proxies):

1. **Contract** — Interface defining the public API of the model.
2. **Model** — Eloquent model implementing the Contract.

Repositories are type-hinted to the **Contract** so cross-package code is decoupled from
the concrete model class.

### Contract

**File:** `packages/rehla/applications/src/Contracts/VisaApplication.php`

```php
<?php

namespace Rehla\Applications\Contracts;

interface VisaApplication
{
    /**
     * Get the application's current status.
     */
    public function getStatus(): string;
}
```

### Model

**File:** `packages/rehla/applications/src/Models/VisaApplication.php`

```php
<?php

namespace Rehla\Applications\Models;

use Illuminate\Database\Eloquent\Model;
use Rehla\Applications\Contracts\VisaApplication as VisaApplicationContract;

class VisaApplication extends Model implements VisaApplicationContract
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visa_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'order_id',
        'status',
        'notes',
    ];

    /**
     * Get the application's current status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
```

### Model Binding (Service Provider)

Bind the Contract to the concrete Model in the package ServiceProvider:

```php
public function register(): void
{
    $this->app->bind(
        \Rehla\Applications\Contracts\VisaApplication::class,
        \Rehla\Applications\Models\VisaApplication::class
    );
}
```

### Model Properties

| Property | Purpose |
|----------|---------| 
| `$table` | Database table name (use package prefix) |
| `$fillable` | Mass-assignable fields |
| `$guarded` | Fields that cannot be mass-assigned |
| `$casts` | Type casting |
| `$with` | Eager loading relationships |

## Repositories

### Repository Pattern

All database access goes through a repository. Never query a model or `DB::table()`
directly from a controller, listener, job, or service.

### Basic Repository Structure

**File:** `packages/rehla/applications/src/Repositories/VisaApplicationRepository.php`

```php
<?php

namespace Rehla\Applications\Repositories;

use Rehla\Applications\Contracts\VisaApplication;
use Rehla\Applications\Models\VisaApplication as VisaApplicationModel;

class VisaApplicationRepository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(
        protected VisaApplicationModel $model,
    ) {}

    /**
     * Return the model class name for this repository.
     */
    public function model(): string
    {
        return VisaApplication::class;
    }

    /**
     * Find an application by ID, or null if not found.
     */
    public function find(int $id): ?VisaApplication
    {
        return $this->model->find($id);
    }

    /**
     * Find an application by ID or throw ModelNotFoundException.
     */
    public function findOrFail(int $id): VisaApplication
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new visa application.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): VisaApplication
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing application.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data, int $id): VisaApplication
    {
        $application = $this->model->findOrFail($id);
        $application->update($data);

        return $application;
    }

    /**
     * Delete an application by ID.
     */
    public function delete(int $id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    /**
     * Find all applications for a given order.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, VisaApplication>
     */
    public function findByOrder(int $orderId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model
            ->where('order_id', $orderId)
            ->get();
    }
}
```

### Repository Binding (Service Provider)

```php
public function register(): void
{
    $this->app->singleton(
        \Rehla\Applications\Repositories\VisaApplicationRepository::class
    );
}
```

---
