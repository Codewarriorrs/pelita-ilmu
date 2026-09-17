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
                    ->label('Minat Program')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('nomor_wa')
                    ->label('Nomor WA')
                    ->icon('heroicon-m-phone')
                    ->searchable(),

                TextColumn::make('status_tindak_lanjut')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'BARU' => 'warning',
                        'DIHUBUNGI' => 'info',
                        'DITERIMA' => 'success',
                        default => 'gray',
                    }),

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
                    ->label('Hubungi WA')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Pendaftaran $record): string {
                        $phone = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', $record->nomor_wa));
                        $nama = urlencode($record->nama_lengkap);
                        $pesan = urlencode("Halo {$record->nama_lengkap}, terima kasih telah mendaftar di Bimbel Pelita Ilmu. Kami ingin mengonfirmasi pendaftaran Anda untuk program {$record->minat_program}. Boleh dibantu beberapa kelengkapan data?");
                        return "https://wa.me/{$phone}?text={$pesan}";
                    })
                    ->openUrlInNewTab()
                    ->action(function (Pendaftaran $record): void {
                        if ($record->status_tindak_lanjut === 'BARU') {
                            $record->update(['status_tindak_lanjut' => 'DIHUBUNGI']);
                        }
                    }),

                Action::make('terima_siswa')
                    ->label('Terima Jadi Siswa')
                    ->icon('heroicon-o-user-check')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Penerimaan Siswa Baru')
                    ->modalDescription('Data calon siswa ini akan otomatis ditambahkan ke tabel Data Siswa dengan status AKTIF.')
                    ->action(function (Pendaftaran $record): void {
                        Siswa::create([
                            'nama_lengkap' => $record->nama_lengkap,
                            'asal_sekolah' => $record->asal_sekolah,
                            'kategori_kelas' => $record->minat_program ?? 'Belum Diatur',
                            'tipe_belajar' => 'KELOMPOK',
                            'tipe_jatuh_tempo' => 'AWAL_BULAN',
                            'status_siswa' => 'AKTIF',
                            'tanggal_daftar' => now(),
                            'no_telp_siswa' => $record->nomor_wa,
                            'biaya_bulanan' => 0,
                        ]);

                        $record->update(['status_tindak_lanjut' => 'DITERIMA']);

                        Notification::make()
                            ->title('Siswa Berhasil Diterima!')
                            ->body("Data {$record->nama_lengkap} telah dipindahkan ke Data Siswa Aktif.")
                            ->success()
                            ->send();
                    }),

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
