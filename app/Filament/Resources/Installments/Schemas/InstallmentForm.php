<?php

namespace App\Filament\Resources\Installments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InstallmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('payment_id')
                    ->label('الدفعة')
                    ->relationship('payment', 'id')
                    ->required(),
                TextInput::make('amount')
                    ->label('المبلغ')
                    ->required()
                    ->numeric()
                    ->prefix('ج.م'),
                DatePicker::make('due_date')
                    ->label('تاريخ الاستحقاق')
                    ->required(),
                DatePicker::make('paid_date')
                    ->label('تاريخ الدفع'),
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوع',
                        'overdue' => 'متأخر',
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }
}
