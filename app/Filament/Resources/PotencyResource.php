<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PotencyResource\Pages;
use App\Models\Potency;
use App\Helpers\ImageHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Http\UploadedFile;

class PotencyResource extends Resource
{
    protected static ?string $model = Potency::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'Potensi & UMKM';
    protected static ?string $modelLabel = 'Potensi & UMKM';
    protected static ?string $pluralModelLabel = 'Potensi & UMKM';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Potensi / Wisata / UMKM')
                            ->placeholder('Contoh: Kripik Tempe Renyah Bu Warsi'),

                        Forms\Components\Select::make('category')
                            ->required()
                            ->options([
                                'UMKM' => 'UMKM (Usaha Mikro Kecil Menengah)',
                                'Wisata' => 'Destinasi Wisata',
                                'Komoditas' => 'Komoditas Unggulan (Tani/Ternak)',
                            ])
                            ->label('Kategori Potensi'),

                        Forms\Components\FileUpload::make('cover_image')
                            ->image()
                            ->maxSize(2048) // 2MB
                            ->label('Foto Sampul / Banner')
                            ->helperText('Format: PNG/JPG/WEBP, Max: 2MB (Akan dikompres otomatis ke .webp)')
                            ->saveUploadedFileUsing(function (UploadedFile $file) {
                                return ImageHelper::convertToWebp($file, 'potencies');
                            }),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('contact_person')
                                    ->required()
                                    ->label('Kontak Pemilik (WhatsApp)')
                                    ->placeholder('Contoh: 6281234567890')
                                    ->regex('/^(08|62)\d{8,13}$/')
                                    ->validationMessages([
                                        'regex' => 'Format nomor WhatsApp harus angka Indonesia yang valid, diawali 08 atau 62 (contoh: 6281234567890 atau 081234567890).',
                                    ])
                                    ->helperText('Wajib nomor HP/WhatsApp yang aktif untuk tombol hubungi penjual/pengelola'),

                                Forms\Components\TextInput::make('price_range')
                                    ->label('Kisaran Harga / Tiket Masuk')
                                    ->placeholder('Contoh: Rp 10.000 - Rp 25.000 atau Rp 5.000 (Tiket Masuk)'),
                            ]),

                        Forms\Components\Textarea::make('location')
                            ->label('Lokasi / Alamat Lengkap')
                            ->placeholder('Contoh: RT 02 / RW 01, Dusun Krajan')
                            ->rows(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Foto Sampul')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Potensi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'UMKM' => 'success',
                        'Wisata' => 'warning',
                        'Komoditas' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact_person')
                    ->label('Kontak WA')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_range')
                    ->label('Kisaran Harga')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Terakhir Diubah')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'UMKM' => 'UMKM',
                        'Wisata' => 'Destinasi Wisata',
                        'Komoditas' => 'Komoditas Unggulan',
                    ])
                    ->label('Kategori'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPotencies::route('/'),
            'create' => Pages\CreatePotency::route('/create'),
            'edit' => Pages\EditPotency::route('/{record}/edit'),
        ];
    }
}
