<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use App\Helpers\ImageHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Profil Desa';
    protected static ?string $modelLabel = 'Profil Desa';
    protected static ?string $pluralModelLabel = 'Profil Desa';
    protected static ?string $navigationGroup = 'Manajemen Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->description('Data identitas utama desa')
                    ->schema([
                        Forms\Components\TextInput::make('nama_desa')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Desa'),
                        Forms\Components\FileUpload::make('logo_path')
                            ->image()
                            ->maxSize(2048) // 2MB as per ADM-2.1
                            ->label('Logo/Lambang Desa')
                            ->helperText('Format: PNG/JPG/WEBP, Max: 2MB (Akan dikompres otomatis ke .webp)')
                            ->saveUploadedFileUsing(function (UploadedFile $file) {
                                return ImageHelper::convertToWebp($file, 'logos');
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Visi, Misi & Sejarah')
                    ->schema([
                        Forms\Components\Textarea::make('visi')
                            ->rows(3)
                            ->label('Visi Desa'),
                        Forms\Components\Textarea::make('misi')
                            ->rows(5)
                            ->label('Misi Desa')
                            ->helperText('Tulis poin-poin misi desa, pisahkan dengan baris baru'),
                        Forms\Components\RichEditor::make('sejarah')
                            ->label('Sejarah Desa')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Geografis & Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('koordinat_peta')
                            ->label('Koordinat Peta')
                            ->placeholder('Contoh: -7.0449, 110.3924')
                            ->helperText('Gunakan koordinat latitude, longitude'),
                        Forms\Components\Textarea::make('google_maps_iframe')
                            ->label('Google Maps Embed Iframe')
                            ->placeholder('<iframe src="..." ...></iframe>')
                            ->helperText('Salin kode HTML embed dari Google Maps untuk peta publik'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->label('Email Resmi'),
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->maxLength(255)
                            ->label('No. Telepon'),
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat Kantor Desa')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->square(),
                Tables\Columns\TextColumn::make('nama_desa')
                    ->label('Nama Desa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Terakhir Diperbarui')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    // Disable create button for profile since it's a single entry config
    public static function canCreate(): bool
    {
        return false;
    }

    // Disable delete for the base village configuration
    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
