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
                \Filament\Schemas\Components\Section::make('معلومات Zoom')
                    ->schema([
                        TextInput::make('zoom_link')
                            ->label('رابط Zoom')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('zoom_meeting_id')
                            ->label('رقم الاجتماع (ID)')
                            ->maxLength(255),
                        TextInput::make('zoom_password')
                            ->label('كلمة المرور')
                            ->maxLength(255),
                    ])->columns(3),
            ]);
    }
}
