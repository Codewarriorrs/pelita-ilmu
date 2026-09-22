<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\Siswa;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static \UnitEnum|string|null $navigationGroup = 'Keuangan';
    protected static ?string $navigationLabel = 'Rekap Pembayaran';
    protected static ?string $modelLabel = 'Rekap Pembayaran';
    protected static ?string $pluralModelLabel = 'Rekap Pembayaran';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        return $user?->isAdmin() ?? true;
    }

    public static function form(Schema $schema): Schema
    {
        $bulanOptions = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $schema
            ->components([
                Select::make('siswa_id')
                    ->label('Pilih Siswa')
                    ->relationship('siswa', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $siswa = Siswa::find($state);
                            if ($siswa) {
                                $set('biaya_dibayar', $siswa->biaya_bulanan);
                            }
                        }
                    }),

                Hidden::make('admin_pencatat_id')
                    ->default(fn () => auth()->id()),

                TextInput::make('biaya_dibayar')
                    ->label('Jumlah SPP Dibayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0),

                Select::make('metode_bayar')
                    ->label('Metode Pembayaran')
                    ->options([
                        'TUNAI' => 'Tunai',
                        'TRANSFER' => 'Transfer Bank',
                        'QRIS' => 'QRIS',
                    ])
                    ->default('TUNAI')
                    ->required(),

                Select::make('status_bayar')
                    ->label('Status Pembayaran')
                    ->options([
                        'LUNAS' => 'Lunas',
                        'BELUM' => 'Belum Lunas',
                    ])
                    ->default('LUNAS')
                    ->required(),

                DatePicker::make('tanggal_bayar')
                    ->label('Tanggal Pembayaran')
                    ->default(now())
                    ->required(),

                Select::make('untuk_bulan')
                    ->label('Untuk Bulan')
                    ->options($bulanOptions)
                    ->default((int) date('m'))
                    ->required(),

                TextInput::make('untuk_tahun')
                    ->label('Untuk Tahun')
                    ->numeric()
                    ->default((int) date('Y'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $bulanOptions = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['siswa', 'adminPencatat']))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('siswa.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('biaya_dibayar')
                    ->label('Biaya SPP')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->state(fn (Pembayaran $record): string => ($bulanOptions[$record->untuk_bulan] ?? $record->untuk_bulan) . ' ' . $record->untuk_tahun)
                    ->badge()
                    ->color('primary'),

                TextColumn::make('metode_bayar')
                    ->label('Metode')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status_bayar')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'LUNAS' => 'success',
                        'BELUM' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('tanggal_bayar')
                    ->label('Tgl Bayar')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('adminPencatat.name')
                    ->label('Pencatat Admin')
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status_bayar')
                    ->label('Status Pembayaran')
                    ->options([
                        'LUNAS' => 'Lunas',
                        'BELUM' => 'Belum Lunas',
                    ]),

                SelectFilter::make('untuk_bulan')
                    ->label('Bulan')
                    ->options($bulanOptions),

                SelectFilter::make('metode_bayar')
                    ->label('Metode Bayar')
                    ->options([
                        'TUNAI' => 'Tunai',
                        'TRANSFER' => 'Transfer',
                        'QRIS' => 'QRIS',
                    ]),
            ])
            ->actions([
                Action::make('tandai_lunas')
                    ->label('Tandai Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Pembayaran $record): bool => $record->status_bayar !== 'LUNAS')
                    ->action(function (Pembayaran $record): void {
                        $record->update([
                            'status_bayar' => 'LUNAS',
                            'tanggal_bayar' => now(),
                            'admin_pencatat_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pembayaran berhasil dikonfirmasi LUNAS')
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
            ->emptyStateHeading('Belum Ada Data Transaksi SPP')
            ->emptyStateDescription('Catat pembayaran SPP siswa bulanan untuk memulai rekap keuangan.')
            ->emptyStateIcon('heroicon-o-banknotes');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
