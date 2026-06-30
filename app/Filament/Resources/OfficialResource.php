<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficialResource\Pages;
use App\Models\Official;
use App\Helpers\ImageHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Http\UploadedFile;

class OfficialResource extends Resource
{
    protected static ?string $model = Official::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Aparat Desa';
    protected static ?string $modelLabel = 'Aparat Desa';
    protected static ?string $pluralModelLabel = 'Aparat Desa';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap')
                            ->placeholder('Contoh: H. Sudirman, S.IP'),

                        Forms\Components\TextInput::make('role')
                            ->required()
                            ->maxLength(255)
                            ->label('Jabatan')
                            ->placeholder('Contoh: Kepala Desa'),

                        Forms\Components\FileUpload::make('photo_path')
                            ->image()
                            ->maxSize(2048) // 2MB as per ADM-2.2
                            ->label('Foto Resmi')
                            ->helperText('Format: PNG/JPG/WEBP, Max: 2MB (Akan dikompres otomatis ke .webp)')
                            ->saveUploadedFileUsing(function (UploadedFile $file) {
                                return ImageHelper::convertToWebp($file, 'officials');
                            }),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->required()
                                    ->label('Urutan Hierarki (Sort Order)')
                                    ->helperText('Angka lebih kecil tampil lebih dulu (misal: Kades = 1, Sekdes = 2)'),

                                Forms\Components\Toggle::make('is_active')
                                    ->default(true)
                                    ->required()
                                    ->label('Status Aktif')
                                    ->helperText('Sembunyikan aparat dari bagan publik jika dinonaktifkan'),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Terakhir Diubah')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListOfficials::route('/'),
            'create' => Pages\CreateOfficial::route('/create'),
            'edit' => Pages\EditOfficial::route('/{record}/edit'),
        ];
    }
}
