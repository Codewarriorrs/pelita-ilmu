<?php

namespace App\Filament\Resources\Users\Schemas;

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
                    ->required(),
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
