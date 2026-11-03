---
name: neon-postgres-optimizer
description: Best practices for optimizing Laravel with Neon Serverless PostgreSQL. Covers PgBouncer connection pooling, auto-suspend caching, latency reduction, and N+1 query prevention.
---

# Neon Serverless PostgreSQL Optimization Standards

## 1. Connection Pooling & PgBouncer
- **Pooler Endpoint**:
  - Web requests MUST connect via Neon's pooled endpoint (`-pooler` in host domain) to eliminate connection-creation overhead.
  - Non-transactional migrations (`migrate`) SHOULD run against direct compute if DDL statements conflict with transaction pooling.
- **PDO Configuration**:
  - In `config/database.php`, configure PostgreSQL driver for serverless pooler safety:
    ```php
    'pgsql' => [
        'driver' => 'pgsql',
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT', '5432'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'require',
        'options' => [
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_EMULATE_PREPARES => true,
        ],
    ],
    ```

## 2. Serverless Cold Start & Round-Trip Mitigation
- **Strict N+1 Elimination**:
  - Remote round-trips to Neon across regions incur latency penalties.
  - NEVER run queries inside iteration loops:
    ```php
    // FORBIDDEN:
    foreach ($siswas as $siswa) {
        $siswa->presensis()->where('tanggal', $today)->count();
    }

    // MANDATORY:
    $siswas->load(['presensis' => fn ($q) => $q->where('tanggal', $today)]);
    ```
- **Batch Writes**:
  - Bulk operations MUST use `upsert()` or `insert()` instead of iterative `save()`.
- **Database Aggregates**:
  - Compute sums, counts, and matrix views inside PostgreSQL via `selectRaw()`, `withCount()`, or CTEs rather than loading full Eloquent models into PHP memory.

## 3. Auto-Suspend & Resource Protection
- **No Lingering Transactions**:
  - Keep transactions as short as possible. Uncommitted transactions prevent Neon compute instances from auto-suspending, driving up compute cost.
- **Cache Lookup Data**:
  - Frequently accessed, rarely modified reference tables (e.g. `mata_pelajarans`, `jenjang_kelas`, system configurations) MUST be cached:
    ```php
    Cache::remember('mata_pelajarans_all', 3600, fn () => MataPelajaran::all());
    ```

## 4. Indexing Strategy
- **Foreign Key Indexing**:
  - Every foreign key used in joins or `whereHas()` MUST have an explicit index in the migration:
    ```php
    $table->foreignId('tentor_id')->index()->constrained('users');
    $table->index(['kelompok_id', 'tanggal']);
    ```
- **Compound Filters**:
  - Create compound indexes for queries that filter by status/role and order by date.

## 5. Delivery Gates
- Verify query count with Laravel Telescope or debug query logs (`DB::listen`) on heavy pages (Rekap Matrix, List Siswa).
- Zero full table scans on multi-tenant or filtered queries.

