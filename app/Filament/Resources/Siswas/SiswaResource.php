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

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

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
                TextInput::make('asal_sekolah')
                    ->label('Asal Sekolah'),
                TextInput::make('kategori_kelas')
                    ->label('Kategori Kelas')
                    ->placeholder('Contoh: 10 SMA / 9 SMP'),
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
                        'AWAL BULAN' => 'Awal Bulan',
                        'AKHIR BULAN' => 'Akhir Bulan',
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
                    ->default('CALON')
                    ->required(),
                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir'),
                TextInput::make('no_telp_siswa')
                    ->label('No. Telepon Siswa')
                    ->tel(),
                TextInput::make('nama_ortu')
                    ->label('Nama Orang Tua'),
                TextInput::make('no_telp_ortu')
                    ->label('No. Telepon Orang Tua')
                    ->tel(),
                TextInput::make('biaya_bulanan')
                    ->label('Biaya Bulanan')
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
            ->defaultSort('nama_lengkap', 'asc')
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('kategori_kelas')
                    ->label('Kelas')
                    ->sortable(),
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
                TextColumn::make('no_telp_siswa')
                    ->label('No. WhatsApp'),
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
                        'AWAL BULAN' => 'Awal Bulan',
                        'AKHIR BULAN' => 'Akhir Bulan',
                    ]),
            ])
            ->actions([
                \Filament\Actions\Action::make('bayar_spp')
                    ->label('Bayar SPP')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->visible(fn () => auth()->user()?->isAdmin() ?? true)
                    ->url(fn (Siswa $record): string => \App\Filament\Resources\PembayaranResource::getUrl('create', ['siswa_id' => $record->id])),
                ViewAction::make(),
                EditAction::make()->visible(fn () => auth()->user()?->isAdmin() ?? true),
                DeleteAction::make()->visible(fn () => auth()->user()?->isAdmin() ?? true),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading('Belum Ada Data Siswa');
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
