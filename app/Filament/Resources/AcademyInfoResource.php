<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademyInfoResource\Pages;
use App\Models\AcademyInfo;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AcademyInfoResource extends Resource
{
    protected static ?string $model = AcademyInfo::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-cog';
    }

    public static function getNavigationLabel(): string
    {
        return 'إعدادات الأكاديمية';
    }

    public static function getPluralModelLabel(): string
    {
        return 'إعدادات الأكاديمية';
    }

    public static function getModelLabel(): string
    {
        return 'إعدادات';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'التواصل والإعدادات';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('phone')
                    ->label('رقم الهاتف الأساسي')
                    ->required(),
                Forms\Components\TextInput::make('phone2')
                    ->label('رقم هاتف إضافي')
                    ->nullable(),
                Forms\Components\TextInput::make('whatsapp_phone')
                    ->label('رقم الواتساب (للتواصل السريع)')
                    ->nullable(),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('العنوان')
                    ->required(),
                Forms\Components\TextInput::make('facebook_url')
                    ->label('رابط فيسبوك')
                    ->url()
                    ->nullable(),
                Forms\Components\TextInput::make('instagram_url')
                    ->label('رابط انستجرام')
                    ->url()
                    ->nullable(),
                Forms\Components\TextInput::make('tiktok_url')
                    ->label('رابط تيك توك')
                    ->url()
                    ->nullable(),
                Forms\Components\FileUpload::make('video_url')
                    ->label('الفيديو التعريفي')
                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                    ->directory('academy-videos')
                    ->maxSize(51200) // 50MB
                    ->nullable()
                    ->columnSpan(1)
                    ->dehydrateStateUsing(fn ($state) => empty($state) ? '' : $state),
                Forms\Components\Textarea::make('about_text')
                    ->label('نبذة عن الأكاديمية')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')->label('رقم الهاتف'),
                Tables\Columns\TextColumn::make('whatsapp_phone')->label('رقم الواتساب'),
                Tables\Columns\TextColumn::make('email')->label('البريد الإلكتروني'),
                Tables\Columns\TextColumn::make('about_text')->label('نبذة عن الأكاديمية')->limit(50),
                Tables\Columns\TextColumn::make('address')->label('العنوان')->limit(30),
            ])
            ->filters([])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademyInfos::route('/'),
            'edit' => Pages\EditAcademyInfo::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return AcademyInfo::count() === 0;
    }
}
