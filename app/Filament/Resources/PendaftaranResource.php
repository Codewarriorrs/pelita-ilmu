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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

                TextInput::make('nama_panggilan')
                    ->label('Nama Panggilan')
                    ->maxLength(50),

                TextInput::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->maxLength(255),

                TextInput::make('minat_program')
                    ->label('Minat Program / Kelas')
                    ->placeholder('Contoh: Regular 10 SMA Mat-1 / Privat SMA')
                    ->maxLength(255),

                TextInput::make('paket_pendaftaran')
                    ->label('Pilihan Pendaftaran')
                    ->maxLength(50),

                TextInput::make('ukuran_kaos')
                    ->label('Ukuran Kaos')
                    ->maxLength(10),

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
                    ->label('Calon Siswa')
                    ->html()
                    ->formatStateUsing(function (Pendaftaran $record): string {
                        $html = '<div class="space-y-1">';
                        $html .= '<div class="font-bold text-gray-900 leading-snug">' . e($record->nama_lengkap) . '</div>';

                        $details = [];
                        if (!empty($record->nama_panggilan)) {
                            $details[] = '<span class="text-gray-500 font-medium">Panggilan:</span> ' . e($record->nama_panggilan);
                        }
                        if (!empty($record->asal_sekolah)) {
                            $details[] = '<span class="text-gray-500 font-medium">Sekolah:</span> ' . e($record->asal_sekolah);
                        }
                        if (!empty($record->nama_ortu)) {
                            $details[] = '<span class="text-gray-500 font-medium">Ortu:</span> ' . e($record->nama_ortu);
                        }

                        if (!empty($details)) {
                            $html .= '<ul class="space-y-0.5 text-xs text-gray-600 list-disc list-inside">';
                            foreach ($details as $detail) {
                                $html .= '<li>' . $detail . '</li>';
                            }
                            $html .= '</ul>';
                        }

                        $html .= '</div>';
                        return $html;
                    })
                    ->searchable(['nama_lengkap', 'asal_sekolah', 'nama_ortu'])
                    ->sortable(),

                TextColumn::make('kelas')
                    ->label('Kelas & Jenjang')
                    ->html()
                    ->formatStateUsing(function (Pendaftaran $record): string {
                        $kelas = $record->kelas ?: '-';
                        $upper = strtoupper($kelas);

                        $badgeClass = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-800';
                        if (str_contains($upper, 'SD')) {
                            $badgeClass = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200';
                        } elseif (str_contains($upper, 'SMP')) {
                            $badgeClass = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200';
                        } elseif (str_contains($upper, 'SMA') || str_contains($upper, 'SMK') || str_contains($upper, 'UTBK')) {
                            $badgeClass = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200';
                        }

                        $html = '<div class="space-y-1">';
                        $html .= '<div><span class="' . $badgeClass . '">' . e($kelas) . '</span></div>';

                        $details = [];
                        if (!empty($record->kategori_kelas)) {
                            $details[] = '<span class="text-gray-500 font-medium">Tipe:</span> ' . e($record->kategori_kelas);
                        }

                        if (!empty($details)) {
                            $html .= '<ul class="space-y-0.5 text-xs text-gray-600 list-disc list-inside">';
                            foreach ($details as $detail) {
                                $html .= '<li>' . $detail . '</li>';
                            }
                            $html .= '</ul>';
                        }

                        $html .= '</div>';
                        return $html;
                    })
                    ->searchable(['kelas', 'kategori_kelas'])
                    ->sortable('kelas'),

                TextColumn::make('program_belajar')
                    ->label('Program Belajar')
                    ->html()
                    ->formatStateUsing(function (Pendaftaran $record): string {
                        $progName = $record->program_belajar ?: $record->program_clean;

                        $html = '<div class="space-y-1">';
                        $html .= '<div class="font-semibold text-gray-900 leading-snug">' . e($progName) . '</div>';

                        $details = [];
                        if (!empty($record->mapel_list)) {
                            $details[] = '<span class="text-gray-500 font-medium">Mapel:</span> ' . e(implode(', ', $record->mapel_list));
                        }

                        if (!empty($record->minat_program) && preg_match('/(Dengan Kaos.*?)(?:\(|$)/i', $record->minat_program, $m)) {
                            $details[] = '<span class="text-gray-500 font-medium">Tambahan:</span> ' . e(trim($m[1]));
                        }

                        if (!empty($details)) {
                            $html .= '<ul class="space-y-0.5 text-xs text-gray-600 list-disc list-inside">';
                            foreach ($details as $detail) {
                                $html .= '<li>' . $detail . '</li>';
                            }
                            $html .= '</ul>';
                        }

                        $html .= '</div>';
                        return $html;
                    })
                    ->wrap()
                    ->searchable(['program_belajar', 'minat_program']),

                TextColumn::make('status_tindak_lanjut')
                    ->label('Status & Tanggal')
                    ->html()
                    ->formatStateUsing(function (Pendaftaran $record): string {
                        $status = $record->status_tindak_lanjut ?: 'BARU';
                        $badgeClass = match ($status) {
                            'DITERIMA' => 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800',
                            'DIHUBUNGI' => 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-800',
                            'BARU' => 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800',
                            default => 'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800',
                        };
                        $label = match ($status) {
                            'DITERIMA' => 'DITERIMA',
                            'DIHUBUNGI' => 'DIHUBUNGI',
                            'BARU' => 'BARU MASUK',
                            default => $status,
                        };

                        $html = '<div class="space-y-1">';
                        $html .= '<div><span class="' . $badgeClass . '">' . e($label) . '</span></div>';

                        $tgl = $record->tanggal_masuk ? $record->tanggal_masuk->format('d M Y, H:i') : '-';
                        $html .= '<ul class="space-y-0.5 text-xs text-gray-600 list-disc list-inside">';
                        $html .= '<li><span class="text-gray-500 font-medium">Masuk:</span> ' . e($tgl) . '</li>';
                        $html .= '</ul>';

                        $html .= '</div>';
                        return $html;
                    })
                    ->sortable('tanggal_masuk'),
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
                    ->label('WA')
                    ->tooltip('Hubungi via WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->button()
                    ->url(fn (Pendaftaran $record): string => $record->wa_url)
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
                        $kelompokFields = [];

                        $isTkOrSd = ($record->program_belajar === 'TK')
                            || str_starts_with((string) $record->program_belajar, 'SD')
                            || str_contains(strtoupper((string) $record->kelas), 'SD')
                            || str_contains(strtoupper((string) $record->kelas), 'TK')
                            || str_contains(strtoupper((string) $record->kelas), 'PAUD');

                        // Cari kelompok belajar: jika SMP/SMA dengan pilihan mapel spesifik
                        if (! $isTkOrSd && ! empty($mapels)) {
                            foreach ($mapels as $idx => $mapelName) {
                                $cleanMapel = trim(preg_replace('/^(TKA|SD|SMP|SMA|Kelas \d+)\s*/i', '', $mapelName));

                                $options = \App\Models\Kelompok::query()
                                    ->where(function ($query) use ($mapelName, $cleanMapel) {
                                        $query->whereHas('mapel', function ($q) use ($mapelName, $cleanMapel) {
                                            $q->where('nama_mapel', 'ILIKE', '%' . trim($mapelName) . '%')
                                              ->orWhere('nama_mapel', 'ILIKE', '%' . $cleanMapel . '%')
                                              ->orWhereRaw('? ILIKE \'%\' || nama_mapel || \'%\'', [trim($mapelName)]);
                                        })->orWhere('nama_kelompok', 'ILIKE', '%' . trim($mapelName) . '%')
                                          ->orWhere('nama_kelompok', 'ILIKE', '%' . $cleanMapel . '%');
                                    })
                                    ->with(['mapel', 'tentor'])
                                    ->withCount('siswa')
                                    ->get()
                                    ->filter(fn ($k) => $k->siswa_count < 9)
                                    ->mapWithKeys(function ($k) {
                                        $sisa = 9 - $k->siswa_count;
                                        $mapelTitle = $k->mapel?->nama_mapel ?? '-';
                                        $tentorName = $k->tentor?->name ?? 'Belum ada tentor';
                                        $jadwal = $k->jadwal_hari ? " ({$k->jadwal_hari})" : '';
                                        return [$k->id => "{$k->nama_kelompok} [{$mapelTitle}]{$jadwal} — {$k->siswa_count}/9 Siswa (Sisa {$sisa}) — Tentor: {$tentorName}"];
                                    })
                                    ->all();

                                $hasOptions = !empty($options);

                                $kelompokFields[] = Select::make("kelompok_mapel_{$idx}")
                                    ->label("Kelompok Belajar: {$mapelName}")
                                    ->options($options)
                                    ->placeholder($hasOptions ? "-- Pilih Kelompok untuk {$mapelName} --" : "Belum ada kelompok tersedia untuk mapel {$mapelName}")
                                    ->required($hasOptions)
                                    ->helperText($hasOptions
                                        ? "Hanya menampilkan kelompok belajar mapel {$mapelName} dengan kuota tersedia (< 9 siswa)."
                                        : "Peringatan: Belum ada kelompok belajar untuk mata pelajaran {$mapelName}. Anda dapat membuat kelompok belajar baru di menu Kelompok Belajar.");
                            }
                        } else {
                            // Untuk TK & SD (semua mapel) atau program paket tanpa per-mapel
                            $options = \App\Models\Kelompok::with(['mapel', 'tentor'])
                                ->withCount('siswa')
                                ->get()
                                ->filter(fn ($k) => $k->siswa_count < 9)
                                ->mapWithKeys(function ($k) {
                                    $sisa = 9 - $k->siswa_count;
                                    $mapelTitle = $k->mapel?->nama_mapel ?? 'Semua Mapel';
                                    $tentorName = $k->tentor?->name ?? 'Belum ada tentor';
                                    $jadwal = $k->jadwal_hari ? " ({$k->jadwal_hari})" : '';
                                    return [$k->id => "{$k->nama_kelompok} [{$mapelTitle}]{$jadwal} — {$k->siswa_count}/9 Siswa (Sisa {$sisa}) — Tentor: {$tentorName}"];
                                })
                                ->all();

                            $kelompokFields[] = Select::make('kelompok_ids')
                                ->label($isTkOrSd ? 'Pilih Kelompok Belajar (TK / SD - Semua Mapel)' : 'Pilih Kelompok Belajar')
                                ->multiple()
                                ->options($options)
                                ->placeholder('-- Pilih Kelompok Belajar Tersedia (< 9 Siswa) --')
                                ->helperText('Untuk jenjang TK & SD, seluruh mapel dibimbing dalam kelompok belajar umum / tematik.');
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
                        $siswa = DB::transaction(function () use ($record, $data): ?Siswa {
                            $freshRecord = Pendaftaran::query()
                                ->whereKey($record->id)
                                ->lockForUpdate()
                                ->first();

                            if (! $freshRecord || $freshRecord->status_tindak_lanjut === 'DITERIMA') {
                                return null;
                            }

                            $normalizedName = mb_strtolower(trim((string) $freshRecord->nama_lengkap));
                            $ortuPhone = trim((string) ($freshRecord->no_telp_ortu ?: $freshRecord->nomor_wa));
                            $siswaPhone = trim((string) $freshRecord->no_telp_siswa);

                            $existingSiswa = Siswa::query()
                                ->whereRaw('LOWER(TRIM(nama_lengkap)) = ?', [$normalizedName])
                                ->where(function (Builder $q) use ($ortuPhone, $siswaPhone, $freshRecord): void {
                                    if ($ortuPhone !== '' && $ortuPhone !== '-') {
                                        $q->orWhere('no_telp_ortu', $ortuPhone);
                                    }
                                    if ($siswaPhone !== '' && $siswaPhone !== '-') {
                                        $q->orWhere('no_telp_siswa', $siswaPhone);
                                    }
                                    if ($freshRecord->tanggal_lahir) {
                                        $q->orWhereDate('tanggal_lahir', $freshRecord->tanggal_lahir);
                                    }
                                })
                                ->first();

                            $tipeBelajar = strtoupper($freshRecord->kategori_kelas ?? '') === 'PRIVAT' ? 'PRIVAT' : 'KELOMPOK';

                            if ($existingSiswa) {
                                if ($existingSiswa->status_siswa === 'CALON') {
                                    $existingSiswa->update(['status_siswa' => 'AKTIF']);
                                }
                                $siswa = $existingSiswa;
                            } else {
                                $siswa = Siswa::create([
                                    'nama_lengkap' => trim((string) $freshRecord->nama_lengkap),
                                    'asal_sekolah' => $freshRecord->asal_sekolah,
                                    'kelas' => $freshRecord->kelas,
                                    'kategori_kelas' => $freshRecord->program_belajar ?: $freshRecord->kategori_kelas ?: 'Reguler',
                                    'pilihan_mapel' => $freshRecord->pilihan_mapel,
                                    'tipe_belajar' => $tipeBelajar,
                                    'tipe_jatuh_tempo' => 'AWAL BULAN',
                                    'status_siswa' => 'AKTIF',
                                    'tanggal_daftar' => now(),
                                    'tanggal_lahir' => $freshRecord->tanggal_lahir,
                                    'alamat_rumah' => $freshRecord->alamat_rumah,
                                    'no_telp_siswa' => $freshRecord->no_telp_siswa,
                                    'nama_ortu' => $freshRecord->nama_ortu,
                                    'no_telp_ortu' => $ortuPhone !== '' ? $ortuPhone : null,
                                    'biaya_bulanan' => $data['biaya_bulanan'] ?? 0,
                                ]);
                            }

                            $selectedKelompokIds = [];
                            foreach ($data as $key => $val) {
                                if (str_starts_with($key, 'kelompok_mapel_') && ! empty($val)) {
                                    $selectedKelompokIds[] = (int) $val;
                                }
                            }
                            if (isset($data['kelompok_ids']) && is_array($data['kelompok_ids'])) {
                                $selectedKelompokIds = array_merge($selectedKelompokIds, $data['kelompok_ids']);
                            }

                            $selectedKelompokIds = array_unique(array_filter($selectedKelompokIds));

                            if (! empty($selectedKelompokIds)) {
                                $siswa->kelompok()->syncWithoutDetaching($selectedKelompokIds);
                            }

                            $freshRecord->update(['status_tindak_lanjut' => 'DITERIMA']);

                            return $siswa;
                        });

                        if (! $siswa) {
                            Notification::make()
                                ->title('Pendaftaran Sudah Diverifikasi')
                                ->body("Data {$record->nama_lengkap} sudah berstatus DITERIMA sebelumnya.")
                                ->warning()
                                ->send();

                            return;
                        }

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
