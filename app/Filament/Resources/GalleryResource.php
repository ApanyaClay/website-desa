<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use App\Helpers\ImageHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Http\UploadedFile;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galeri Kegiatan';
    protected static ?string $modelLabel = 'Galeri Kegiatan';
    protected static ?string $pluralModelLabel = 'Galeri Kegiatan';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Judul Album / Kegiatan')
                            ->placeholder('Contoh: Peringatan HUT RI ke-80'),

                        Forms\Components\DatePicker::make('event_date')
                            ->required()
                            ->label('Tanggal Kegiatan')
                            ->default(now()),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Album')
                            ->placeholder('Tulis deskripsi singkat mengenai kegiatan ini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Foto-Foto Kegiatan')
                    ->description('Tambahkan dokumentasi foto untuk kegiatan ini (Unggah banyak sekaligus)')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->image()
                                    ->maxSize(2048) // 2MB
                                    ->required()
                                    ->label('Foto')
                                    ->helperText('Max: 2MB (Akan dikompres ke .webp)')
                                    ->saveUploadedFileUsing(function (UploadedFile $file) {
                                        return ImageHelper::convertToWebp($file, 'galleries');
                                    }),
                                Forms\Components\TextInput::make('caption')
                                    ->maxLength(255)
                                    ->label('Keterangan / Caption')
                                    ->placeholder('Contoh: Lomba Balap Karung Anak-Anak'),
                                Forms\Components\Hidden::make('file_type')
                                    ->default('image'),
                            ])
                            ->grid(3) // premium grid view of photos in repeater
                            ->defaultItems(1)
                            ->label('Foto')
                            ->addActionLabel('Tambah Foto Kegiatan')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Kegiatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal Kegiatan')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Foto')
                    ->counts('items'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Terakhir Diubah')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                Tables\Filters\Filter::make('event_date')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn($q) => $q->whereDate('event_date', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn($q) => $q->whereDate('event_date', '<=', $data['sampai_tanggal']));
                    })
                    ->label('Tanggal Kegiatan'),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
