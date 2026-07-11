<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static string|\UnitEnum|null $navigationGroup = 'شؤون الطلاب';
    protected static ?string $navigationLabel = 'التقييمات العامة';
    protected static ?string $pluralModelLabel = 'التقييمات العامة';
    protected static ?string $modelLabel = 'تقييم عام';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم ولي الأمر / الطالب')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('course_name')
                    ->label('اسم الكورس (إن وجد)')
                    ->maxLength(255),
                Forms\Components\Select::make('score')
                    ->label('التقييم (النجوم)')
                    ->options([
                        1 => '1 نجمة',
                        2 => '2 نجمة',
                        3 => '3 نجوم',
                        4 => '4 نجوم',
                        5 => '5 نجوم',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('is_approved')
                    ->label('تمت الموافقة للظهور بالموقع')
                    ->default(false),
                Forms\Components\Textarea::make('feedback')
                    ->label('رأي ولي الأمر / الطالب')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_name')
                    ->label('الكورس')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('التقييم')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        5 => 'success',
                        4 => 'info',
                        3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('موافق عليه'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('حالة الموافقة')
                    ->placeholder('الكل')
                    ->trueLabel('موافق عليه')
                    ->falseLabel('بانتظار الموافقة'),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportCsv::make('testimonials', [
                        'الاسم' => 'name',
                        'الكورس' => 'course_name',
                        'التقييم' => 'score',
                        'التعليق' => 'comment',
                        'موافق عليه' => fn ($r) => $r->is_approved ? 'نعم' : 'لا',
                    ]),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
