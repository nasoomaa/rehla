# Data Access

## Go through the repository, never the query builder

Every read and write goes through a repository. Reaching for `DB::table(...)` or the model's query
builder from a controller, listener, job, or service bypasses the layer the whole codebase is built
on — and makes the operation impossible to reuse or override.

```php
// Good — the operation lives on the repository, named for what it does.
$this->mediaRepository->findByUuid($uuid);
```

```php
// Bad — a service reaching past the repository into the table.
DB::table('media')
    ->where('uuid', $uuid)
    ->first();
```

If the repository has no method for what you need, **add one**. That is the extension point:

```php
/**
 * Find a media record by its UUID.
 */
public function findByUuid(string $uuid): ?Media
{
    return $this->model
        ->where('uuid', $uuid)
        ->first();
}
```

**The one place `DB` is expected is a DataGrid's `prepareQueryBuilder()`**, which is built on the
query builder by design and returns a `Builder` for the grid to paginate. `DB::transaction()` and
`DB::raw()` inside a repository are also fine — the objection is to querying *tables* from outside
the data layer, not to the facade itself.

### Scope every owner-bound query in the repository

A repository method that touches customer-owned or application-owned data takes the owner id as its
first argument and filters on it. Then there is no call shape that can reach another user's rows:

```php
/**
 * One of a customer's orders, or null when it is not theirs.
 */
public function findForCustomer(int $customerId, int $orderId): ?Order
{
    return $this->model
        ->where('customer_id', $customerId)
        ->where('id', $orderId)
        ->first();
}
```

---
