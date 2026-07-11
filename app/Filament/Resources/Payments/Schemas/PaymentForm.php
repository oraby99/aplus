<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn ($query) => $query->where('type', 'student'))
                    ->required(),
                Select::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('total_amount')
                    ->label('إجمالي المبلغ')
                    ->required()
                    ->numeric()
                    ->prefix('ج.م'),
                TextInput::make('paid_amount')
                    ->label('المبلغ المدفوع')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('ج.م'),
                TextInput::make('discount')
                    ->label('الخصم')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('ج.م'),
                Select::make('payment_plan')
                    ->label('خطة الدفع')
                    ->options([
                        'installments' => 'أقساط',
                        'full_amount' => 'كاش (كامل)',
                        'monthly' => 'شهري',
                        'quarterly' => 'ربع سنوي',
                    ])
                    ->required()
                    ->default('monthly'),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'partial' => 'جزئي',
                        'paid' => 'مدفوع',
                        'overdue' => 'متأخر',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }
}
