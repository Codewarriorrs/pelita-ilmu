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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

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
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? trim($state) : $state)
                    ->rule(fn (Get $get, ?Siswa $record): \Closure => function (string $attribute, mixed $value, \Closure $fail) use ($get, $record): void {
                        $normalized = mb_strtolower(trim((string) $value));
                        if ($normalized === '') {
                            return;
                        }

                        $ortuPhone = trim((string) $get('no_telp_ortu'));
                        $siswaPhone = trim((string) $get('no_telp_siswa'));
                        $tglLahir = $get('tanggal_lahir');

                        $hasIdentifier = ($ortuPhone !== '' && $ortuPhone !== '-')
                            || ($siswaPhone !== '' && $siswaPhone !== '-')
                            || filled($tglLahir);

                        if (! $hasIdentifier) {
                            return;
                        }

                        $exists = Siswa::query()
                            ->when($record, fn (Builder $q) => $q->where('id', '!=', $record->id))
                            ->whereRaw('LOWER(TRIM(nama_lengkap)) = ?', [$normalized])
                            ->where(function (Builder $q) use ($ortuPhone, $siswaPhone, $tglLahir): void {
                                if ($ortuPhone !== '' && $ortuPhone !== '-') {
                                    $q->orWhere('no_telp_ortu', $ortuPhone);
                                }
                                if ($siswaPhone !== '' && $siswaPhone !== '-') {
                                    $q->orWhere('no_telp_siswa', $siswaPhone);
                                }
                                if (filled($tglLahir)) {
                                    $q->orWhereDate('tanggal_lahir', Carbon::parse($tglLahir)->toDateString());
                                }
                            })
                            ->exists();

                        if ($exists) {
                            $fail('Siswa dengan nama serta nomor telepon / tanggal lahir tersebut sudah terdaftar.');
                        }
                    }),
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
                        'AWAL BULAN' => 'Jatuh Tempo Awal Bulan',
                        'AKHIR BULAN' => 'Jatuh Tempo Akhir Bulan',
                    ])
                    ->default('AWAL BULAN')
                    ->required(),
                Select::make('status_siswa')
                    ->label('Status Siswa')
                    ->options([
                        'CALON' => 'Calon',
                        'BELUM_MULAI' => 'Belum Mulai',
                        'AKTIF' => 'Aktif',
                        'NONAKTIF' => 'Nonaktif',
                    ])
                    ->default('AKTIF')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (mixed $state, callable $set, callable $get): void {
                        if ($state === 'NONAKTIF' && blank($get('tanggal_keluar'))) {
                            $set('tanggal_keluar', now()->toDateString());
                        }
                    }),
                DatePicker::make('tanggal_keluar')
                    ->label('Tanggal Keluar / Berhenti')
                    ->visible(fn (Get $get): bool => $get('status_siswa') === 'NONAKTIF')
                    ->helperText('Tanggal siswa resmi mengundurkan diri atau selesai masa bimbingan.')
                    ->default(null),
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
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('Catatan atau keterangan khusus siswa')
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
                        'BELUM_MULAI' => '🟠 BELUM MULAI',
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
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(25)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('-'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status_siswa')
                    ->label('Status Siswa')
                    ->options([
                        'AKTIF' => 'Aktif',
                        'CALON' => 'Calon',
                        'BELUM_MULAI' => 'Belum Mulai',
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
                        'AWAL BULAN' => 'Jatuh Tempo Awal Bulan',
                        'AKHIR BULAN' => 'Jatuh Tempo Akhir Bulan',
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
