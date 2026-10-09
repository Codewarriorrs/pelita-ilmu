<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\Pages;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';

    protected static \UnitEnum|string|null $navigationGroup = 'Kesiswaan';
    protected static ?string $navigationLabel = 'Pendaftaran Online';
    protected static ?string $modelLabel = 'Pendaftaran Online';
    protected static ?string $pluralModelLabel = 'Pendaftaran Online';
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
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->maxLength(255),

                TextInput::make('minat_program')
                    ->label('Minat Program / Kelas')
                    ->placeholder('Contoh: Regular 10 SMA Mat-1 / Privat SMA')
                    ->maxLength(255),

                TextInput::make('nomor_wa')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                Select::make('status_tindak_lanjut')
                    ->label('Status Tindak Lanjut')
                    ->options([
                        'BARU' => 'Baru Masuk',
                        'DIHUBUNGI' => 'Sudah Dihubungi',
                        'DITERIMA' => 'Diterima Jadi Siswa',
                    ])
                    ->default('BARU')
                    ->required(),

                DateTimePicker::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_masuk', 'desc')
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Calon Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable(),

                TextColumn::make('minat_program')
                    ->label('Minat Program'),

                TextColumn::make('nomor_wa')
                    ->label('Nomor WA')
                    ->icon('heroicon-m-phone')
                    ->searchable(),

                TextColumn::make('status_tindak_lanjut')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'BARU' => '🟡 BARU MASUK',
                        'DIHUBUNGI' => '🔵 DIHUBUNGI',
                        'DITERIMA' => '🟢 DITERIMA',
                        default => $state,
                    })
                    ->weight('extrabold'),

                TextColumn::make('tanggal_masuk')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status_tindak_lanjut')
                    ->label('Status Tindak Lanjut')
                    ->options([
                        'BARU' => 'Baru Masuk',
                        'DIHUBUNGI' => 'Sudah Dihubungi',
                        'DITERIMA' => 'Diterima',
                    ]),
            ])
            ->actions([
                Action::make('hubungi_wa')
                    ->label('WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Pendaftaran $record): string {
                        $targetWa = $record->no_telp_ortu ?: $record->nomor_wa ?: '';
                        $phone = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', $targetWa));
                        $nama = $record->nama_lengkap;
                        $program = $record->program_belajar ?: $record->minat_program ?: 'Bimbel';
                        $pesan = urlencode("Halo Bapak/Ibu {$record->nama_ortu}, terima kasih telah mendaftarkan ananda {$nama} di Bimbel Pelita Ilmu untuk program {$program}. Kami ingin mengonfirmasi pendaftaran dan jadwal belajar ananda.");
                        return "https://wa.me/{$phone}?text={$pesan}";
                    })
                    ->openUrlInNewTab()
                    ->action(function (Pendaftaran $record): void {
                        if ($record->status_tindak_lanjut === 'BARU') {
                            $record->update(['status_tindak_lanjut' => 'DIHUBUNGI']);
                        }
                    }),

                Action::make('tinjau_verifikasi')
                    ->label('Tinjau & Verifikasi')
                    ->icon('heroicon-o-check-badge')
                    ->color('primary')
                    ->visible(fn (Pendaftaran $record): bool => $record->status_tindak_lanjut !== 'DITERIMA')
                    ->modalHeading(fn (Pendaftaran $record): string => "Tinjau & Verifikasi Pendaftaran: {$record->nama_lengkap}")
                    ->modalDescription('Periksa kelengkapan data calon siswa, tentukan biaya bulanan, dan tempatkan ke kelompok belajar yang tersedia sebelum menerima siswa.')
                    ->modalSubmitActionLabel('Terima & Daftarkan Siswa')
                    ->form(function (Pendaftaran $record): array {
                        $mapels = is_array($record->pilihan_mapel) ? $record->pilihan_mapel : [];
                        
                        // Cari kelompok belajar yang mapelnya cocok dan kuota < 9 siswa
                        $kelompokFields = [];

                        if (!empty($mapels)) {
                            foreach ($mapels as $idx => $mapelName) {
                                $options = \App\Models\Kelompok::query()
                                    ->whereHas('mapel', function ($q) use ($mapelName) {
                                        $q->where('nama_mapel', 'ILIKE', '%' . trim($mapelName) . '%')
                                          ->orWhereRaw('? ILIKE \'%\' || nama_mapel || \'%\'', [trim($mapelName)]);
                                    })
                                    ->withCount('siswa')
                                    ->get()
                                    ->filter(fn ($k) => $k->siswa_count < 9)
                                    ->mapWithKeys(function ($k) {
                                        $sisa = 9 - $k->siswa_count;
                                        $tentorName = $k->tentor?->name ?? 'Belum ada tentor';
                                        return [$k->id => "{$k->nama_kelompok} ({$k->jadwal_hari}) — {$k->siswa_count}/9 Siswa (Sisa {$sisa}) — Tentor: {$tentorName}"];
                                    })
                                    ->all();

                                // Jika tidak ada kelompok yang spesifik sesuai nama mapel, berikan pilihan semua kelompok yang kapasitasnya < 9
                                if (empty($options)) {
                                    $options = \App\Models\Kelompok::withCount('siswa')
                                        ->get()
                                        ->filter(fn ($k) => $k->siswa_count < 9)
                                        ->mapWithKeys(function ($k) {
                                            $sisa = 9 - $k->siswa_count;
                                            $mapelTitle = $k->mapel?->nama_mapel ?? 'Umum';
                                            return [$k->id => "{$k->nama_kelompok} [{$mapelTitle}] — {$k->siswa_count}/9 Siswa (Sisa {$sisa})"];
                                        })
                                        ->all();
                                }

                                $kelompokFields[] = Select::make("kelompok_mapel_{$idx}")
                                    ->label("Kelompok Belajar: {$mapelName}")
                                    ->options($options)
                                    ->placeholder('-- Pilih Kelompok yang Tersedia (< 9 Siswa) --')
                                    ->required(count($options) > 0)
                                    ->helperText('Hanya menampilkan kelompok belajar dengan kapasitas tersedia (< 9 siswa).');
                            }
                        } else {
                            // Fallback jika program paket tanpa pilihan array mapel (misal SD / TK)
                            $options = \App\Models\Kelompok::withCount('siswa')
                                ->get()
                                ->filter(fn ($k) => $k->siswa_count < 9)
                                ->mapWithKeys(function ($k) {
                                    $sisa = 9 - $k->siswa_count;
                                    $mapelTitle = $k->mapel?->nama_mapel ?? 'Umum';
                                    return [$k->id => "{$k->nama_kelompok} [{$mapelTitle}] — {$k->siswa_count}/9 Siswa (Sisa {$sisa})"];
                                })
                                ->all();

                            $kelompokFields[] = Select::make('kelompok_ids')
                                ->label('Pilih Kelompok Belajar')
                                ->multiple()
                                ->options($options)
                                ->placeholder('-- Pilih Kelompok Belajar Tersedia --')
                                ->helperText('Hanya menampilkan kelompok belajar dengan kapasitas tersedia (< 9 siswa).');
                        }

                        $mapelDisplay = !empty($mapels) ? implode(', ', $mapels) : ($record->program_belajar ?: 'Semua Mapel Pokok');

                        return [
                            \Filament\Forms\Components\Placeholder::make('info_pendaftar')
                                ->label('Ringkasan Data Calon Siswa')
                                ->content(new \Illuminate\Support\HtmlString("
                                    <div class='p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 text-xs space-y-1.5'>
                                        <div><strong>Nama Lengkap:</strong> {$record->nama_lengkap} (" . ($record->kelas ?: 'Kelas belum diatur') . ")</div>
                                        <div><strong>Asal Sekolah:</strong> " . ($record->asal_sekolah ?: '-') . "</div>
                                        <div><strong>Tanggal Lahir:</strong> " . ($record->tanggal_lahir ? \Carbon\Carbon::parse($record->tanggal_lahir)->translatedFormat('d F Y') : '-') . "</div>
                                        <div><strong>Kategori Belajar:</strong> " . ($record->kategori_kelas ?: 'Reguler') . "</div>
                                        <div><strong>Program / Mapel:</strong> <span class='text-primary-600 font-bold'>{$mapelDisplay}</span></div>
                                        <div><strong>Nama Orang Tua:</strong> " . ($record->nama_ortu ?: '-') . " (WA: " . ($record->no_telp_ortu ?: $record->nomor_wa ?: '-') . ")</div>
                                        <div><strong>No. HP Siswa:</strong> " . ($record->no_telp_siswa ?: '-') . "</div>
                                        <div><strong>Alamat:</strong> " . ($record->alamat_rumah ?: '-') . "</div>
                                    </div>
                                ")),

                            TextInput::make('biaya_bulanan')
                                ->label('Biaya Bulanan (SPP yang Disepakati)')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(200000)
                                ->required()
                                ->helperText('Nominal SPP bulanan yang akan tercatat pada tagihan siswa.'),

                            ...$kelompokFields,
                        ];
                    })
                    ->action(function (Pendaftaran $record, array $data): void {
                        $tipeBelajar = strtoupper($record->kategori_kelas ?? '') === 'PRIVAT' ? 'PRIVAT' : 'KELOMPOK';

                        // 1. Buat data Siswa Aktif
                        $siswa = Siswa::create([
                            'nama_lengkap' => $record->nama_lengkap,
                            'asal_sekolah' => $record->asal_sekolah,
                            'kelas' => $record->kelas,
                            'kategori_kelas' => $record->program_belajar ?: $record->kategori_kelas ?: 'Reguler',
                            'pilihan_mapel' => $record->pilihan_mapel,
                            'tipe_belajar' => $tipeBelajar,
                            'tipe_jatuh_tempo' => 'AWAL BULAN',
                            'status_siswa' => 'AKTIF',
                            'tanggal_daftar' => now(),
                            'tanggal_lahir' => $record->tanggal_lahir,
                            'alamat_rumah' => $record->alamat_rumah,
                            'no_telp_siswa' => $record->no_telp_siswa,
                            'nama_ortu' => $record->nama_ortu,
                            'no_telp_ortu' => $record->no_telp_ortu ?: $record->nomor_wa,
                            'biaya_bulanan' => $data['biaya_bulanan'] ?? 0,
                        ]);

                        // 2. Petakan Siswa ke Kelompok Belajar yang Dipilih
                        $selectedKelompokIds = [];
                        foreach ($data as $key => $val) {
                            if (str_starts_with($key, 'kelompok_mapel_') && !empty($val)) {
                                $selectedKelompokIds[] = (int) $val;
                            }
                        }
                        if (isset($data['kelompok_ids']) && is_array($data['kelompok_ids'])) {
                            $selectedKelompokIds = array_merge($selectedKelompokIds, $data['kelompok_ids']);
                        }

                        $selectedKelompokIds = array_unique(array_filter($selectedKelompokIds));

                        if (!empty($selectedKelompokIds)) {
                            $siswa->kelompok()->syncWithoutDetaching($selectedKelompokIds);
                        }

                        // 3. Update status pendaftaran menjadi DITERIMA
                        $record->update(['status_tindak_lanjut' => 'DITERIMA']);

                        Notification::make()
                            ->title('Siswa Berhasil Diterima & Terpetakan!')
                            ->body("Data {$record->nama_lengkap} telah aktif dan ditempatkan ke kelompok belajar yang dipilih.")
                            ->success()
                            ->send();
                    }),

                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Pendaftaran Online Baru')
            ->emptyStateDescription('Formulir pendaftaran dari Landing Page publik akan ditampilkan otomatis di sini.')
            ->emptyStateIcon('heroicon-o-user-plus');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }
}
