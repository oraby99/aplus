<?php

namespace App\Filament\Resources\Installments\Schemas;

use App\Models\Payment;
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
                    ->label('الدفعة التابع لها القسط')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->options(function () {
                        return Payment::with(['student', 'course', 'group'])->get()->mapWithKeys(function ($p) {
                            $student = $p->student?->name ?? 'طالب غير محدد';
                            $course = $p->course?->title ?? 'كورس غير محدد';
                            $group = $p->group ? " [{$p->group->name}]" : '';
                            return [$p->id => "{$student} - {$course}{$group} (دفعة #{$p->id})"];
                        });
                    }),
                TextInput::make('amount')
                    ->label('مبلغ القسط')
                    ->required()
                    ->numeric()
                    ->prefix('ج.م'),
                DatePicker::make('due_date')
                    ->label('تاريخ الاستحقاق')
                    ->required(),
                DatePicker::make('paid_date')
                    ->label('تاريخ الدفع (إذا تم سداده)'),
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
