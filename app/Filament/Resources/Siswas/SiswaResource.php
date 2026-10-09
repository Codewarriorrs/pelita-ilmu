<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages;
use App\Models\Siswa;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? true;
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Data Siswa';
    protected static ?string $modelLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Data Siswa';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('kelas')
                    ->label('Kelas Siswa')
                    ->placeholder('Contoh: 8 SMP / 5 SD / 10'),
                TextInput::make('asal_sekolah')
                    ->label('Asal Sekolah'),
                TextInput::make('kategori_kelas')
                    ->label('Program / Jenjang')
                    ->placeholder('Contoh: Reguler / SMP 3 Mapel'),
                Select::make('tipe_belajar')
                    ->label('Tipe Belajar')
                    ->options([
                        'KELOMPOK' => 'Kelompok',
                        'PRIVAT' => 'Privat',
                    ])
                    ->default('KELOMPOK')
                    ->required(),
                Select::make('tipe_jatuh_tempo')
                    ->label('Tipe Jatuh Tempo')
                    ->options([
                        'AWAL BULAN' => 'Awal Bulan (Tgl 7)',
                        'AKHIR BULAN' => 'Akhir Bulan (Tgl 25)',
                    ])
                    ->default('AWAL BULAN')
                    ->required(),
                Select::make('status_siswa')
                    ->label('Status Siswa')
                    ->options([
                        'CALON' => 'Calon',
                        'AKTIF' => 'Aktif',
                        'NONAKTIF' => 'Nonaktif',
                    ])
                    ->default('AKTIF')
                    ->required(),
                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir'),
                TextInput::make('nama_ortu')
                    ->label('Nama Orang Tua'),
                TextInput::make('no_telp_ortu')
                    ->label('Nomor WhatsApp Orang Tua')
                    ->tel(),
                TextInput::make('no_telp_siswa')
                    ->label('Nomor WhatsApp / HP Siswa')
                    ->tel(),
                TextInput::make('biaya_bulanan')
                    ->label('Biaya Bulanan (SPP)')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                Textarea::make('alamat_rumah')
                    ->label('Alamat Rumah')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_daftar', 'desc')
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('kategori_kelas')
                    ->label('Program')
                    ->sortable()
                    ->limit(25),
                TextColumn::make('tipe_belajar')
                    ->label('Tipe'),
                TextColumn::make('status_siswa')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'AKTIF' => '🟢 AKTIF',
                        'CALON' => '🟡 CALON',
                        'NONAKTIF' => '🔴 NONAKTIF',
                        default => $state,
                    })
                    ->weight('extrabold'),
                TextColumn::make('no_telp_ortu')
                    ->label('WhatsApp Ortu')
                    ->icon('heroicon-m-phone'),
                TextColumn::make('biaya_bulanan')
                    ->label('Biaya/Bln')
                    ->money('IDR', locale: 'id')
                    ->visible(fn () => auth()->user()?->isAdmin() ?? true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status_siswa')
                    ->label('Status Siswa')
                    ->options([
                        'AKTIF' => 'Aktif',
                        'CALON' => 'Calon',
                        'NONAKTIF' => 'Nonaktif',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('tipe_belajar')
                    ->label('Tipe Belajar')
                    ->options([
                        'KELOMPOK' => 'Kelompok',
                        'PRIVAT' => 'Privat',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('tipe_jatuh_tempo')
                    ->label('Tipe Jatuh Tempo')
                    ->options([
                        'AWAL BULAN' => 'Awal Bulan (Tgl 7)',
                        'AKHIR BULAN' => 'Akhir Bulan (Tgl 25)',
                    ]),
            ])
            ->actions([
                \Filament\Actions\Action::make('bayar_spp')
                    ->iconButton()
                    ->icon('heroicon-o-banknotes')
                    ->tooltip('Bayar SPP')
                    ->color('success')
                    ->visible(fn () => auth()->user()?->isAdmin() ?? true)
                    ->url(fn (Siswa $record): string => \App\Filament\Resources\PembayaranResource::getUrl('create', ['siswa_id' => $record->id])),
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton()->visible(fn () => auth()->user()?->isAdmin() ?? true),
                DeleteAction::make()->iconButton()->visible(fn () => auth()->user()?->isAdmin() ?? true),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn () => auth()->user()?->isAdmin() ?? true),
                ]),
            ])->emptyStateHeading('Belum Ada Data Siswa');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if ($user && $user->isTentor()) {
            $query->whereHas('kelompok', function (Builder $q) use ($user) {
                $q->where('tentor_id', $user->id);
            });
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if ($user && $user->isTentor()) {
            $query->whereHas('kelompok', function (Builder $q) use ($user) {
                $q->where('tentor_id', $user->id);
            });
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view' => Pages\ViewSiswa::route('/{record}'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
