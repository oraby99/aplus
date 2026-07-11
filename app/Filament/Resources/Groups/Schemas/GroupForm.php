<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('level_id')
                    ->label('المرحلة')
                    ->relationship('level', 'name')
                    ->required(),
                Select::make('teacher_id')
                    ->label('المعلم')
                    ->relationship('teacher', 'name', fn ($query) => $query->where('type', 'teacher')),
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('max_students')
                    ->label('الحد الأقصى للطلاب')
                    ->required()
                    ->numeric()
                    ->default(15),
                TextInput::make('schedule')
                    ->label('الجدول'),
            ]);
    }
}
