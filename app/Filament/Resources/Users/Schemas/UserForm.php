<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? mb_strtolower(trim($state)) : $state)
                    ->unique(table: 'users', column: 'email', ignoreRecord: true)
                    ->rule(fn (?User $record): \Closure => function (string $attribute, mixed $value, \Closure $fail) use ($record): void {
                        $normalized = mb_strtolower(trim((string) $value));
                        if ($normalized === '') {
                            return;
                        }

                        $exists = User::query()
                            ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                            ->whereRaw('LOWER(TRIM(email)) = ?', [$normalized])
                            ->exists();

                        if ($exists) {
                            $fail('Alamat email ini sudah digunakan oleh akun lain.');
                        }
                    }),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->placeholder(fn (string $operation): string => $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password baru'),
                Select::make('role')
                    ->options([
                        'ADMIN' => 'Administrator',
                        'TENTOR' => 'Tentor / Pengajar',
                    ])
                    ->required()
                    ->default('TENTOR'),
                DateTimePicker::make('tanggal_daftar')
                    ->default(now())
                    ->required(),
            ]);
    }
}
