<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('العنوان')
                    ->required(),
                Textarea::make('description')
                    ->label('الوصف')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->label('المدة')
                    ->placeholder('مثال: 3 شهور، أو 30 ساعة')
                    ->nullable(),
                TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('ج.م'),
                Toggle::make('is_active')
                    ->label('نشط')
                    ->required(),
            ]);
    }
}
