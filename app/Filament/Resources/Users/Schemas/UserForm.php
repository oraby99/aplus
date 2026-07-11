<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->required(),
                \Filament\Forms\Components\Select::make('type')
                    ->label('نوع المستخدم')
                    ->options([
                        'student' => 'طالب',
                        'teacher' => 'معلم',
                        'admin' => 'إداري',
                    ])
                    ->required()
                    ->default('student'),
            ]);
    }
}
