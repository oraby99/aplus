<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn ($query) => $query->where('type', 'student'))
                    ->required(),
                Select::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('تاريخ البدء')
                    ->required(),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'active' => 'نشط',
                        'inactive' => 'غير نشط',
                        'completed' => 'مكتمل',
                    ])
                    ->required()
                    ->default('active'),
            ]);
    }
}
