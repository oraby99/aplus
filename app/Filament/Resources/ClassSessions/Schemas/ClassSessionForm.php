<?php

namespace App\Filament\Resources\ClassSessions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClassSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name')
                    ->required(),
                DatePicker::make('session_date')
                    ->label('تاريخ الحصة')
                    ->required(),
                TextInput::make('topic')
                    ->label('الموضوع'),
            ]);
    }
}
