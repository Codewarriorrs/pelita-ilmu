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
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
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
                \Filament\Forms\Components\Placeholder::make('daftar_kelompok_table')
                    ->label('Daftar Kelompok Belajar yang Diikuti')
                    ->content(function (?Siswa $record): \Illuminate\Support\HtmlString {
                        if (! $record) {
                            return new \Illuminate\Support\HtmlString('<div style="font-size: 12px; color: #64748b; font-style: italic;">Kelompok belajar dapat ditentukan setelah data siswa disimpan.</div>');
                        }

                        $record->loadMissing(['kelompok.mapel', 'kelompok.tentor']);
                        $kelompoks = $record->kelompok;

                        if ($kelompoks->isEmpty()) {
                            return new \Illuminate\Support\HtmlString('<div style="padding: 10px 14px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; font-size: 12px; color: #64748b;">Siswa belum terdaftar di kelompok belajar manapun.</div>');
                        }

                        $rows = '';
                        foreach ($kelompoks as $i => $k) {
                            $no = $i + 1;
                            $namaKel = htmlspecialchars($k->nama_kelompok);
                            $mapel = htmlspecialchars($k->mapel?->nama_mapel ?? '-');
                            $hari = htmlspecialchars($k->jadwal_hari ?? '-');
                            $jam = ($k->jam_mulai ? substr($k->jam_mulai, 0, 5) : '') . ($k->jam_selesai ? ' - ' . substr($k->jam_selesai, 0, 5) : '');
                            $tentor = htmlspecialchars($k->tentor?->name ?? 'Belum ada tentor');

                            $rows .= "<tr style='border-bottom: 1px solid #e2e8f0;'>
                                <td style='padding: 8px 12px; font-weight: 600; text-align: center; width: 40px;'>{$no}</td>
                                <td style='padding: 8px 12px; font-weight: 700; color: #193836;'>{$namaKel}</td>
                                <td style='padding: 8px 12px; color: #0f766e; font-weight: 600;'>{$mapel}</td>
                                <td style='padding: 8px 12px; color: #475569;'>{$hari} {$jam}</td>
                                <td style='padding: 8px 12px; color: #334155;'>{$tentor}</td>
                            </tr>";
                        }

                        return new \Illuminate\Support\HtmlString("
                            <div style='border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; background: #ffffff;'>
                                <table style='width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;'>
                                    <thead style='background: #f1f5f9; color: #334155; font-size: 11px; text-transform: uppercase;'>
                                        <tr>
                                            <th style='padding: 8px 12px; text-align: center;'>#</th>
                                            <th style='padding: 8px 12px;'>Nama Kelompok</th>
                                            <th style='padding: 8px 12px;'>Mata Pelajaran</th>
                                            <th style='padding: 8px 12px;'>Jadwal Belajar</th>
                                            <th style='padding: 8px 12px;'>Tentor Pengampu</th>
                                        </tr>
                                    </thead>
                                    <tbody>{$rows}</tbody>
                                </table>
                            </div>
                        ");
                    })
                    ->columnSpanFull(),
                Select::make('kelompok')
                    ->label('Ubah / Tempatkan Kelompok Belajar')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->helperText('Pilih kelompok belajar yang diikuti oleh siswa.')
                    ->visible(fn () => auth()->user()?->isAdmin() ?? true),
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
                TextColumn::make('kelompok_list')
                    ->label('Kelompok Belajar')
                    ->state(function (Siswa $record): \Illuminate\Support\HtmlString {
                        $kelompoks = $record->kelompok;
                        $count = $kelompoks->count();
                        if ($count === 0) {
                            return new \Illuminate\Support\HtmlString('<span style="font-size: 11px; color: #94a3b8; font-style: italic;">Belum ada kelompok</span>');
                        }

                        $itemsHtml = '';
                        foreach ($kelompoks as $k) {
                            $itemsHtml .= '<div style="padding: 4px 6px; border-bottom: 1px dashed #e2e8f0; font-size: 11px; font-weight: 500; color: #1e293b; white-space: nowrap;">' . e($k->nama_kelompok) . '</div>';
                        }

                        return new \Illuminate\Support\HtmlString("
                            <div x-data=\"{ open: false }\" @click.stop style=\"position: relative; display: inline-block;\">
                                <button type=\"button\" 
                                        @click.stop=\"open = !open\" 
                                        style=\"display: inline-flex; align-items: center; gap: 5px; padding: 0.2rem 0.6rem; font-size: 0.7rem; font-weight: 800; color: #ffffff; background-color: #0f766e; border: none; border-radius: 0.45rem; cursor: pointer; text-align: left; letter-spacing: 0.03em; box-shadow: 0 1px 2px rgba(15, 118, 110, 0.25);\">
                                    <span>{$count} KELOMPOK</span>
                                    <svg :class=\"{ 'rotate-180': open }\" style=\"width: 11px; height: 11px; transition: transform 0.15s ease;\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2.5\" d=\"M19 9l-7 7-7-7\" /></svg>
                                </button>
                                <div x-show=\"open\" 
                                     x-cloak 
                                     @click.outside=\"open = false\" 
                                     @click.stop
                                     style=\"position: absolute; top: calc(100% + 4px); left: 0; z-index: 50; min-width: 170px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.12); max-height: 140px; overflow-y: auto; padding: 4px;\">
                                    {$itemsHtml}
                                </div>
                            </div>
                        ");
                    }),
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
                \Filament\Tables\Filters\SelectFilter::make('kelompok')
                    ->label('Kelompok Belajar')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->searchable()
                    ->preload(),
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
                \Filament\Actions\Action::make('lihat_kelompok')
                    ->iconButton()
                    ->icon('heroicon-o-user-group')
                    ->color('info')
                    ->tooltip('Lihat Kelompok Belajar')
                    ->modalHeading(fn (Siswa $record) => "Kelompok Belajar — {$record->nama_lengkap}")
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->infolist([
                        RepeatableEntry::make('kelompok')
                            ->label('Daftar Kelompok Belajar yang Diikuti')
                            ->schema([
                                TextEntry::make('nama_kelompok')
                                    ->label('Nama Kelompok')
                                    ->weight('bold'),
                                TextEntry::make('mapel.nama_mapel')
                                    ->label('Mata Pelajaran')
                                    ->badge()
                                    ->color('primary')
                                    ->placeholder('-'),
                                TextEntry::make('tentor.name')
                                    ->label('Tentor')
                                    ->placeholder('-'),
                                TextEntry::make('jadwal_hari')
                                    ->label('Hari')
                                    ->placeholder('-'),
                                TextEntry::make('jam_mulai')
                                    ->label('Jam Belajar')
                                    ->formatStateUsing(fn ($record) => filled($record->jam_mulai) ? substr($record->jam_mulai, 0, 5) . ' - ' . substr($record->jam_selesai, 0, 5) : '-')
                                    ->placeholder('-'),
                            ])
                            ->columns(3)
                            ->placeholder('Siswa ini belum terdaftar di kelompok belajar manapun.'),
                    ]),
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
        $query = parent::getEloquentQuery()->with(['kelompok.mapel', 'kelompok.tentor']);

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
