<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('class_session_id')
                    ->label('الحصة')
                    ->relationship('classSession', 'id')
                    ->required(),
                Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn ($query) => $query->where('type', 'student'))
                    ->required(),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'present' => 'حاضر',
                        'absent' => 'غائب',
                        'late' => 'متأخر',
                    ])
                    ->required()
                    ->default('present'),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->columnSpanFull(),
            ]);
    }
}
