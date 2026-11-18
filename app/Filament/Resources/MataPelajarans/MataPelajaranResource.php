<?php

namespace App\Filament\Resources\MataPelajarans;

use App\Filament\Resources\MataPelajarans\Pages;
use App\Filament\Resources\MataPelajarans\RelationManagers;
use App\Models\MataPelajaran;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static \UnitEnum|string|null $navigationGroup = 'Akademik';
    protected static ?string $navigationLabel = 'Mata Pelajaran';
    protected static ?string $modelLabel = 'Mata Pelajaran';
    protected static ?string $pluralModelLabel = 'Mata Pelajaran';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_mapel')
                    ->label('Nama Mata Pelajaran')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Fisika / Matematika Wajib / Geografi')
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? trim($state) : $state),

                Select::make('jenjang')
                    ->label('Jenjang Pendidikan')
                    ->options([
                        'TK' => 'TK / PAUD',
                        'SD' => 'SD (Sekolah Dasar)',
                        'SMP' => 'SMP (Sekolah Menengah Pertama)',
                        'SMA' => 'SMA / SMK / UTBK',
                        'UMUM' => 'Umum / Semua Jenjang',
                    ])
                    ->placeholder('-- Pilih Jenjang --')
                    ->searchable(),

                TextInput::make('tingkat_kelas')
                    ->label('Tingkat Kelas')
                    ->placeholder('Contoh: Kelas 10-12 SMA / Kelas 7-9 SMP')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('nama_mapel')
                    ->label('Nama Mata Pelajaran')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('jenjang')
                    ->label('Jenjang')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'TK' => 'warning',
                        'SD' => 'info',
                        'SMP' => 'primary',
                        'SMA' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('tingkat_kelas')
                    ->label('Tingkat Kelas')
                    ->default('-')
                    ->searchable(),

                TextColumn::make('kelompok_count')
                    ->counts('kelompok')
                    ->label('Jml Kelompok')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenjang')
                    ->label('Filter Jenjang')
                    ->options([
                        'TK' => 'TK',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'UMUM' => 'Umum',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Data Mata Pelajaran');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KelompokRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}