---
name: filament-resource-architect
description: High-performance, secure Filament v3/v4/v5 architecture standards for Laravel. Enforces query scoping, eager loading, policy authorization, responsive forms, and lean table configurations.
---

# Filament Resource Architecture Standards

## 1. Query Scoping & Security
- **Mandatory `getEloquentQuery()` Scoping**:
  - Resources displaying tenant- or role-sensitive data MUST override `getEloquentQuery()` in the Resource class.
  - Role-based isolation MUST be handled at the query level, not just hidden in the UI:
    ```php
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->hasRole('TENTOR')) {
            $query->whereHas('kelompoks', fn (Builder $q) => $q->where('tentor_id', $user->id));
        }

        return $query;
    }
    ```
- **Policy Enforcement**:
  - Every Filament Resource MUST be bound to a Laravel Model Policy.
  - NEVER bypass authorization checks in table actions or relation managers.
  - Use `visible()` closures referencing policies or roles for destructive/attach actions.

## 2. Table Performance & N+1 Prevention
- **Explicit Eager Loading**:
  - ALWAYS call `->modifyQueryUsing(fn ($query) => $query->with(['rel1', 'rel2']))` or eager-load in `getEloquentQuery()` when displaying relationship columns (`TextColumn::make('relation.field')`).
- **Pagination Constraints**:
  - Tables MUST default to 10 or 25 records per page:
    ```php
    ->defaultPaginationPageOption(10)
    ->paginationPageOptions([10, 25, 50])
    ```
- **Searchable Columns**:
  - NEVER make unindexed text or JSON columns `->searchable()` without a composite index or database-level full-text index.
  - Use `searchable(isIndividual: true)` only where required.

## 3. Forms & Livewire Reactivity
- **Debounced Inputs**:
  - Input fields MUST use `->lazy()` or `->debounce('500ms')` to avoid unnecessary Livewire round-trips:
    ```php
    TextInput::make('kode')->lazy()
    ```
- **Reactive / Dependent Fields**:
  - Use `->live()` ONLY when downstream components strictly depend on the value.
  - Always pair with `->live(onBlur: true)` or `->debounce('500ms')` when tracking text inputs.
- **Responsive Layout**:
  - Forms MUST specify breakpoints explicitly (`columns(['default' => 1, 'sm' => 2, 'lg' => 3])`).

## 4. Actions & Modals
- **Destructive Actions**:
  - `DeleteAction`, `ForceDeleteAction`, and bulk deletes MUST include `->requiresConfirmation()`.
- **Slideover for Complex Forms**:
  - Dense forms or detail views in modals SHOULD use `->slideOver()` to maximize readability.
- **Smart Redirects**:
  - Override `getRedirectUrl()` on Create and Edit pages to return to the index page rather than lingering on edit screens unless requested:
    ```php
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    ```

## 5. Delivery Gates
- All modified Resource, Page, and RelationManager files MUST pass `php -l`.
- Verify role switching: Test view with both `ADMIN` and scoped roles (e.g., `TENTOR`).

