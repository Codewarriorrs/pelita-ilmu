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
                        $badgeStyle = match ($status) {
                            'DITERIMA' => 'display: inline-block; padding: 3px 10px; font-size: 11px; font-weight: 800; color: #ffffff; background-color: #16a34a; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.03em;',
                            'DIHUBUNGI' => 'display: inline-block; padding: 3px 10px; font-size: 11px; font-weight: 800; color: #ffffff; background-color: #2563eb; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.03em;',
                            'BARU' => 'display: inline-block; padding: 3px 10px; font-size: 11px; font-weight: 800; color: #78350f; background-color: #eab308; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.03em;',
                            default => 'display: inline-block; padding: 3px 10px; font-size: 11px; font-weight: 800; color: #ffffff; background-color: #4b5563; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.03em;',
                        };
                        $label = match ($status) {
                            'DITERIMA' => 'DITERIMA',
                            'DIHUBUNGI' => 'DIHUBUNGI',
                            'BARU' => 'BARU MASUK',
                            default => $status,
                        };

                        $html = '<div class="space-y-1">';
                        $html .= '<div><span style="' . $badgeStyle . '">' . e($label) . '</span></div>';

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

                        // Ekstrak angka kelas calon siswa, misal "Kelas 10 SMA" -> "10", "Kelas 7 SMP" -> "7"
                        preg_match('/\b(10|11|12|[1-9]|TK)\b/i', (string) $record->kelas, $km);
                        $targetKelas = $km[1] ?? null;

                        // Cari kelompok belajar: jika SMP/SMA dengan pilihan mapel spesifik
                        if (! $isTkOrSd && ! empty($mapels)) {
                            foreach ($mapels as $idx => $mapelName) {
                                $cleanMapel = trim(preg_replace('/^(TKA|SD|SMP|SMA|Kelas \d+)\s*/i', '', $mapelName));

                                $query = \App\Models\Kelompok::query();

                                // Filter tegas per kelas: Murid kelas 10 hanya melihat kelompok kelas 10
                                if ($targetKelas) {
                                    $query->where(function ($sub) use ($targetKelas) {
                                        $sub->where('nama_kelompok', 'ILIKE', "%{$targetKelas}%")
                                            ->orWhereHas('mapel', fn ($mq) => $mq->where('nama_mapel', 'ILIKE', "%{$targetKelas}%"));
                                    });
                                }

                                if (stripos($mapelName, 'UTBK') !== false || stripos($mapelName, 'Penalaran') !== false) {
                                    $query->where(function ($q) {
                                        $q->where('nama_kelompok', 'ILIKE', '%UTBK%')
                                          ->orWhere('nama_kelompok', 'ILIKE', '%PK&PM%')
                                          ->orWhere('nama_kelompok', 'ILIKE', '%TKA%')
                                          ->orWhereHas('mapel', fn ($mq) => $mq->where('nama_mapel', 'ILIKE', '%UTBK%'));
                                    });
                                } else {
                                    $lower = strtolower($mapelName);
                                    $mapelKeywords = [];

                                    if (str_contains($lower, 'fisika')) {
                                        $mapelKeywords = ['FISIKA', 'FIS'];
                                    } elseif (str_contains($lower, 'kimia')) {
                                        $mapelKeywords = ['KIMIA', 'KIM'];
                                    } elseif (str_contains($lower, 'biologi')) {
                                        $mapelKeywords = ['BIOLOGI', 'BIO'];
                                    } elseif (str_contains($lower, 'sosiologi')) {
                                        $mapelKeywords = ['SOSIOLOGI', 'SOSIO', 'IPS'];
                                    } elseif (str_contains($lower, 'ekonomi')) {
                                        $mapelKeywords = ['EKONOMI', 'EKO', 'AKUN', 'IPS'];
                                    } elseif (str_contains($lower, 'geografi') || str_contains($lower, 'sejarah')) {
                                        $mapelKeywords = ['IPS', 'SOSIO'];
                                    } elseif (str_contains($lower, 'indonesia')) {
                                        $mapelKeywords = ['B. INDO', 'B INDO', 'INDO'];
                                    } elseif (str_contains($lower, 'inggris')) {
                                        $mapelKeywords = ['B. ING', 'B ING', 'ING'];
                                    } elseif (str_contains($lower, 'matematika')) {
                                        if (str_contains($lower, 'lanjut')) {
                                            $mapelKeywords = ['MAT.LAN', 'MATLAN'];
                                        } elseif (str_contains($lower, 'wajib')) {
                                            $mapelKeywords = ['MAT.W', 'MAT W', 'MTK W'];
                                        } else {
                                            $mapelKeywords = ['MAT', 'MTK'];
                                        }
                                    } else {
                                        $mapelKeywords = [trim($mapelName)];
                                        if ($cleanMapel) $mapelKeywords[] = $cleanMapel;
                                    }

                                    $query->where(function ($sub) use ($mapelKeywords) {
                                        foreach ($mapelKeywords as $kw) {
                                            $sub->orWhere('nama_kelompok', 'ILIKE', "%{$kw}%")
                                                ->orWhereHas('mapel', fn ($mq) => $mq->where('nama_mapel', 'ILIKE', "%{$kw}%"));
                                        }
                                    });
                                }

                                $options = $query
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

                                // Fallback jika kelompok khusus mapel belum ada di rombel kelas ini: tampilkan seluruh kelompok kelas ini yang tersedia
                                if (empty($options) && $targetKelas) {
                                    $fallbackQuery = \App\Models\Kelompok::query()
                                        ->where(function ($sub) use ($targetKelas) {
                                            $sub->where('nama_kelompok', 'ILIKE', "%{$targetKelas}%")
                                                ->orWhereHas('mapel', fn ($mq) => $mq->where('nama_mapel', 'ILIKE', "%{$targetKelas}%"));
                                        });

                                    $options = $fallbackQuery
                                        ->with(['mapel', 'tentor'])
                                        ->withCount('siswa')
                                        ->get()
                                        ->filter(fn ($k) => $k->siswa_count < 9)
                                        ->mapWithKeys(function ($k) {
                                            $sisa = 9 - $k->siswa_count;
                                            $mapelTitle = $k->mapel?->nama_mapel ?? '-';
                                            $tentorName = $k->tentor?->name ?? 'Belum ada tentor';
                                            $jadwal = $k->jadwal_hari ? " ({$k->jadwal_hari})" : '';
                                            return [$k->id => "{$k->nama_kelompok} [{$mapelTitle}]{$jadwal} — {$k->siswa_count}/9 Siswa — Tentor: {$tentorName}"];
                                        })
                                        ->all();
                                }

                                $hasOptions = !empty($options);

                                $kelompokFields[] = Select::make("kelompok_mapel_{$idx}")
                                    ->label("Kelompok Belajar: {$mapelName}")
                                    ->options($options)
                                    ->placeholder($hasOptions ? "-- Pilih Kelompok untuk {$mapelName} --" : "Belum ada kelompok tersedia untuk mapel {$mapelName}")
                                    ->required($hasOptions)
                                    ->helperText($hasOptions
                                        ? "Hanya menampilkan kelompok belajar {$mapelName} kelas {$record->kelas} dengan kuota tersedia (< 9 siswa)."
                                        : "Peringatan: Belum ada kelompok belajar untuk mata pelajaran {$mapelName} di kelas ini. Anda dapat membuat kelompok belajar baru di menu Kelompok Belajar.");
                            }
                        } else {
                            // Untuk TK & SD (semua mapel) atau program paket tanpa per-mapel
                            $genQuery = \App\Models\Kelompok::query();
                            if ($targetKelas) {
                                $genQuery->where(function ($sub) use ($targetKelas) {
                                    $sub->where('nama_kelompok', 'ILIKE', "%{$targetKelas}%")
                                        ->orWhereHas('mapel', fn ($mq) => $mq->where('nama_mapel', 'ILIKE', "%{$targetKelas}%"));
                                });
                            }

                            $options = $genQuery->with(['mapel', 'tentor'])
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
                        $tglDaftar = $record->tanggal_masuk ? $record->tanggal_masuk->translatedFormat('d F Y') : '-';
                        $invNo = 'REG-' . str_pad((string) $record->id, 5, '0', STR_PAD_LEFT);
                        $hasKaos = !empty($record->ukuran_kaos) || str_contains((string) $record->paket_pendaftaran, 'Dengan Kaos');
                        $biayaDaftar = $hasKaos ? 0 : 35000;
                        $biayaKaos = $hasKaos ? 70000 : 0;
                        $totalBiayaAwal = $biayaDaftar + $biayaKaos;
                        $biayaDaftarFmt = 'Rp ' . number_format($biayaDaftar, 0, ',', '.');
                        $biayaKaosFmt = 'Rp ' . number_format($biayaKaos, 0, ',', '.');
                        $totalAwalFmt = 'Rp ' . number_format($totalBiayaAwal, 0, ',', '.');
                        $ukuranKaosText = $record->ukuran_kaos ? "Ukuran: {$record->ukuran_kaos}" : 'Tanpa Kaos';

                        return [
                            \Filament\Forms\Components\Placeholder::make('info_pendaftar')
                                ->label('')
                                ->content(new \Illuminate\Support\HtmlString("
                                    <div style='background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 18px; font-family: \"Plus Jakarta Sans\", system-ui, -apple-system, sans-serif; color: #1e293b;'>
                                        <!-- Header Nota Invoice -->
                                        <div style='display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #0f766e; padding-bottom: 12px; margin-bottom: 14px;'>
                                            <div>
                                                <div style='font-size: 11px; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; color: #0f766e;'>BIMBEL PELITA ILMU</div>
                                                <div style='font-size: 15px; font-weight: 800; color: #0f172a;'>NOTA RINGKASAN PENDAFTARAN</div>
                                                <div style='font-size: 11px; color: #64748b;'>Semarang, Jawa Tengah</div>
                                            </div>
                                            <div style='text-align: right;'>
                                                <span style='display: inline-block; background: #0f766e; color: #ffffff; font-family: \"Courier New\", monospace; font-size: 12px; font-weight: 700; padding: 4px 8px; border-radius: 4px;'>#{$invNo}</span>
                                                <div style='font-size: 11px; color: #64748b; margin-top: 4px; font-weight: 600;'>Tgl: {$tglDaftar}</div>
                                            </div>
                                        </div>

                                        <!-- Informasi Siswa & Wali (Tanpa Nested Box, Hanya Section Divider) -->
                                        <div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; font-size: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px; margin-bottom: 14px;'>
                                            <div style='display: flex; flex-direction: column; gap: 4px;'>
                                                <div><span style='color: #64748b;'>Nama Lengkap:</span> <strong style='color: #0f172a;'>{$record->nama_lengkap}</strong></div>
                                                <div><span style='color: #64748b;'>Panggilan:</span> <span style='font-weight: 700; color: #1e293b;'>" . ($record->nama_panggilan ?: '-') . "</span></div>
                                                <div><span style='color: #64748b;'>Jenjang / Kelas:</span> <strong style='color: #0f766e;'>" . ($record->kelas ?: '-') . "</strong> (" . ($record->kategori_kelas ?: 'Reguler') . ")</div>
                                                <div><span style='color: #64748b;'>Asal Sekolah:</span> <span style='color: #1e293b;'>" . ($record->asal_sekolah ?: '-') . "</span></div>
                                            </div>
                                            <div style='display: flex; flex-direction: column; gap: 4px;'>
                                                <div><span style='color: #64748b;'>Nama Orang Tua:</span> <strong style='color: #0f172a;'>" . ($record->nama_ortu ?: '-') . "</strong></div>
                                                <div><span style='color: #64748b;'>WhatsApp Wali:</span> <span style='font-family: \"Courier New\", monospace; color: #0f766e; font-weight: 700;'>" . ($record->no_telp_ortu ?: $record->nomor_wa ?: '-') . "</span></div>
                                                <div><span style='color: #64748b;'>No. HP Murid:</span> <span style='font-family: \"Courier New\", monospace; color: #334155;'>" . ($record->no_telp_siswa ?: '-') . "</span></div>
                                                <div style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'><span style='color: #64748b;'>Alamat:</span> <span style='color: #1e293b;'>" . ($record->alamat_rumah ?: '-') . "</span></div>
                                            </div>
                                        </div>

                                        <!-- Itemized Invoice Table (Tanpa Nested Box) -->
                                        <table style='width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;'>
                                            <thead style='background: #f8fafc; color: #334155; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;'>
                                                <tr>
                                                    <th style='padding: 8px 10px; border-bottom: 1px solid #cbd5e1;'>Deskripsi Layanan</th>
                                                    <th style='padding: 8px 10px; border-bottom: 1px solid #cbd5e1;'>Rincian / Keterangan</th>
                                                    <th style='padding: 8px 10px; border-bottom: 1px solid #cbd5e1; text-align: right;'>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style='border-bottom: 1px solid #e2e8f0;'>
                                                    <td style='padding: 8px 10px; font-weight: 600; color: #1e293b;'>Biaya Administrasi Pendaftaran</td>
                                                    <td style='padding: 8px 10px; color: #64748b;'>" . ($hasKaos ? 'Gratis (Termasuk dalam Paket Kaos)' : 'Registrasi standar bimbel') . "</td>
                                                    <td style='padding: 8px 10px; text-align: right; font-family: \"Courier New\", monospace; font-weight: 700; color: #0f172a;'>{$biayaDaftarFmt}</td>
                                                </tr>" . ($hasKaos ? "
                                                <tr style='border-bottom: 1px solid #e2e8f0;'>
                                                    <td style='padding: 8px 10px; font-weight: 600; color: #1e293b;'>Paket Kaos Eksklusif Bimbel</td>
                                                    <td style='padding: 8px 10px; color: #64748b;'>Kaos resmi Pelita Ilmu ({$ukuranKaosText}) + Free Registrasi</td>
                                                    <td style='padding: 8px 10px; text-align: right; font-family: \"Courier New\", monospace; font-weight: 700; color: #0f172a;'>{$biayaKaosFmt}</td>
                                                </tr>" : "") . "
                                                <tr style='border-bottom: 1px solid #e2e8f0;'>
                                                    <td style='padding: 8px 10px; font-weight: 600; color: #1e293b;'>Program Bimbingan Belajar</td>
                                                    <td style='padding: 8px 10px; color: #0f766e; font-weight: 600;'>{$mapelDisplay}</td>
                                                    <td style='padding: 8px 10px; text-align: right; color: #94a3b8; font-style: italic;'>Sesuai SPP</td>
                                                </tr>
                                            </tbody>
                                            <tfoot style='background: #f8fafc; border-top: 1.5px solid #0f766e; font-weight: 700; color: #0f172a;'>
                                                <tr>
                                                    <td colspan='2' style='padding: 10px; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em;'>Total Tagihan Pendaftaran Awal</td>
                                                    <td style='padding: 10px; text-align: right; font-family: \"Courier New\", monospace; font-size: 13px; color: #0f766e; font-weight: 800;'>{$totalAwalFmt}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
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
