<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles; 

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tanggal_daftar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Keamanan Otorisasi Akses Panel Admin / Tentor / Guru.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isTentor();
    }

    /**
     * Helper cek apakah role saat ini adalah Administrator.
     */
    public function isAdmin(): bool
    {
        if (strcasecmp((string) ($this->role ?? ''), 'TENTOR') === 0) {
            return false;
        }

        return strcasecmp((string) ($this->role ?? 'ADMIN'), 'ADMIN') === 0
            || (method_exists($this, 'hasRole') && $this->hasRole('ADMIN'));
    }

    /**
     * Helper cek apakah role saat ini adalah Tentor.
     */
    public function isTentor(): bool
    {
        return strcasecmp((string) ($this->role ?? ''), 'TENTOR') === 0
            || (method_exists($this, 'hasRole') && $this->hasRole('TENTOR'));
    }
}
