---
name: pest-testing-suite
description: High-efficiency Pest PHP testing standards for Laravel and Filament admin panels. Covers architecture tests, Livewire component testing, table/action assertions, and role scoping verification.
---

# Pest PHP Testing Suite Standards

## 1. Architecture Testing (`arch()`)
- Place architecture tests in `tests/Feature/ArchitectureTest.php`:
  ```php
  arch('no debugging statements left in codebase')
      ->expect(['dd', 'dump', 'ray', 'var_dump'])
      ->not->toBeUsed();

  arch('models extend eloquent')
      ->expect('App\Models')
      ->toExtend('Illuminate\Database\Eloquent\Model');

  arch('policies follow naming conventions')
      ->expect('App\Policies')
      ->toHaveSuffix('Policy');
  ```

## 2. Filament Page & Table Testing
- Use `Pest\Livewire\livewire` to assert panel behaviour:
  ```php
  use function Pest\Livewire\livewire;

  describe('SiswaResource List Page', function () {
      beforeEach(function () {
          $this->admin = User::factory()->create(['role' => 'ADMIN']);
          $this->tentor = User::factory()->create(['role' => 'TENTOR']);
      });

      it('renders list page for admin', function () {
          $this->actingAs($this->admin);

          livewire(\App\Filament\Resources\Siswas\Pages\ListSiswas::class)
              ->assertOk();
      });

      it('scopes records strictly for tentor', function () {
          $ownKelompok = Kelompok::factory()->create(['tentor_id' => $this->tentor->id]);
          $otherKelompok = Kelompok::factory()->create();

          $ownSiswa = Siswa::factory()->create();
          $otherSiswa = Siswa::factory()->create();

          $ownKelompok->siswas()->attach($ownSiswa);
          $otherKelompok->siswas()->attach($otherSiswa);

          $this->actingAs($this->tentor);

          livewire(\App\Filament\Resources\Siswas\Pages\ListSiswas::class)
              ->assertCanSeeTableRecords([$ownSiswa])
              ->assertCanNotSeeTableRecords([$otherSiswa]);
      });
  });
  ```

## 3. Table Action & Policy Verification
- Assert UI action visibility matching policies:
  ```php
  it('prevents tentor from deleting students', function () {
      $this->actingAs($this->tentor);

      livewire(\App\Filament\Resources\Siswas\Pages\ListSiswas::class)
          ->assertTableActionHidden('delete');
  });
  ```

## 4. Test Performance & Hygiene
- **Database Strategy**:
  - Use `Illuminate\Foundation\Testing\RefreshDatabase` or transactions.
  - Create ONLY records needed for assertions; NEVER run full database seeders inside individual tests.
- **Strict Assertions**:
  - Always verify state mutations in database:
    ```php
    assertDatabaseHas('detail_presensis', [
        'siswa_id' => $siswa->id,
        'status' => 'HADIR',
    ]);
    ```

## 5. Delivery Gates
- All test suites MUST run cleanly:
  ```bash
  vendor/bin/pest
  ```
- 0 failures, 0 deprecation notices, 0 unhandled exceptions.

