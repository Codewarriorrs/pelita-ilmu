<?php

namespace App\Filament\Resources\Ruangans;

use App\Filament\Resources\Ruangans\Pages;
use App\Models\Ruangan;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RuanganResource extends Resource
{
    protected static ?string $model = Ruangan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Data Ruangan';
    protected static ?string $modelLabel = 'Ruangan';
    protected static ?string $pluralModelLabel = 'Data Ruangan';
    protected static \UnitEnum|string|null $navigationGroup = 'Akademik';
    protected static ?int $navigationSort = 3;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_ruangan')
                    ->label('Nama Ruangan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Contoh: Ruang 1 (Utama)')
                    ->maxLength(255),

                TextInput::make('kapasitas')
                    ->label('Kapasitas (Murid)')
                    ->numeric()
                    ->default(10)
                    ->suffix('Siswa'),

                TextInput::make('fasilitas')
                    ->label('Fasilitas')
                    ->placeholder('Contoh: AC, Whiteboard, Proyektor')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('keterangan')
                    ->label('Keterangan / Catatan')
                    ->placeholder('Catatan peruntukan ruangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_ruangan')
                    ->label('Nama Ruangan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->suffix(' Siswa')
                    ->sortable(),

                TextColumn::make('fasilitas')
                    ->label('Fasilitas')
                    ->placeholder('-')
                    ->limit(40),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('-')
                    ->limit(30),
            ])
            ->actions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Data Ruangan')
            ->emptyStateDescription('Tambahkan ruangan belajar untuk bimbingan kelompok dan privat.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRuangans::route('/'),
            'create' => Pages\CreateRuangan::route('/create'),
            'edit' => Pages\EditRuangan::route('/{record}/edit'),
        ];
    }
}
