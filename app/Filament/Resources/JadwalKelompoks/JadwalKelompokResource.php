<?php

namespace App\Filament\Resources\JadwalKelompoks;

use App\Filament\Resources\JadwalKelompoks\Pages;
use App\Models\DetailPresensi;
use App\Models\JadwalKelompok;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JadwalKelompokResource extends Resource
{
    protected static ?string $model = JadwalKelompok::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Jadwal & Presensi';
    protected static ?string $modelLabel = 'Jadwal Sesi';
    protected static ?string $pluralModelLabel = 'Jadwal & Presensi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kelompok_id')
                    ->label('Kelompok Belajar')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('tanggal_sesi')
                    ->label('Tanggal Pertemuan')
                    ->default(now())
                    ->required(),

                Select::make('status_sesi')
                    ->label('Status Pertemuan')
                    ->options([
                        'TERJADWAL' => 'Terjadwal',
                        'SELESAI'   => 'Selesai',
                        'BATAL'     => 'Batal',
                    ])
                    ->default('TERJADWAL')
                    ->required(),

                TextInput::make('materi_pembahasan')
                    ->label('Materi Pembahasan')
                    ->placeholder('Contoh: Aljabar Linier & Matriks')
                    ->columnSpanFull(),

                Textarea::make('catatan_tentor')
                    ->label('Catatan Tentor')
                    ->placeholder('Catatan kendala atau tugas tambahan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->modifyQueryUsing(fn (Builder $query) => $query->with(['kelompok.siswa', 'detailPresensi']))
            ->defaultSort('tanggal_sesi', 'desc')
            ->emptyStateHeading('Belum Ada Sesi Pertemuan')
            ->emptyStateDescription('Buat jadwal pertemuan baru untuk memulai pencatatan absensi.')
            ->columns([
                TextColumn::make('tanggal_sesi')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('kelompok.nama_kelompok')
                    ->label('Kelompok Belajar')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kelompok.tentor.name')
                    ->label('Tentor')
                    ->sortable(),

                TextColumn::make('status_sesi')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'SELESAI'   => 'success',
                        'TERJADWAL' => 'info',
                        'BATAL'     => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('materi_pembahasan')
                    ->label('Materi')
                    ->limit(25)
                    ->placeholder('Belum diisi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Action interaktif: Pop-up Modal Presensi Siswa
                Action::make('presensi')
                    ->label('Presensi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('success')
                    ->modalHeading(fn (JadwalKelompok $record) => 'Presensi Sesi: ' . $record->kelompok->nama_kelompok)
                    ->modalDescription('Tentukan status kehadiran untuk setiap siswa di kelompok ini.')
                    ->fillForm(function (JadwalKelompok $record): array {
                        // Tarik daftar siswa yang terdaftar di kelompok ini
                        $daftarSiswa = $record->kelompok->siswa;
                        $presensiTersimpan = $record->detailPresensi->keyBy('siswa_id');

                        return [
                            'daftar_kehadiran' => $daftarSiswa->map(function ($siswa) use ($presensiTersimpan) {
                                return [
                                    'siswa_id'   => $siswa->id,
                                    'nama_siswa' => $siswa->nama_lengkap,
                                    'status'     => $presensiTersimpan[$siswa->id]->status_kehadiran ?? 'HADIR',
                                ];
                            })->toArray(),
                        ];
                    })
                    ->form([
                        Repeater::make('daftar_kehadiran')
                            ->label('Daftar Murid')
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->schema([
                                TextInput::make('nama_siswa')
                                    ->label('Nama Siswa')
                                    ->disabled(),

                                Radio::make('status')
                                    ->label('Kehadiran')
                                    ->options([
                                        'HADIR' => 'Hadir',
                                        'IZIN'  => 'Izin',
                                        'SAKIT' => 'Sakit',
                                        'ALPA'  => 'Alpa',
                                    ])
                                    ->inline()
                                    ->required(),
                            ]),
                    ])
                    ->action(function (array $data, JadwalKelompok $record): void {
                        foreach ($data['daftar_kehadiran'] as $item) {
                            DetailPresensi::updateOrCreate(
                                [
                                    'jadwal_id' => $record->id,
                                    'siswa_id'  => $item['siswa_id'],
                                ],
                                [
                                    'status_kehadiran' => $item['status'],
                                ]
                            );
                        }

                        $record->update(['status_sesi' => 'SELESAI']);

                        Notification::make()
                            ->title('Presensi berhasil disimpan')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index'  => Pages\ListJadwalKelompoks::route('/'),
            'create' => Pages\CreateJadwalKelompok::route('/create'),
            'edit'   => Pages\EditJadwalKelompok::route('/{record}/edit'),
        ];
    }
}