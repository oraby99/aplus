<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable(),
                TextColumn::make('course.title')
                    ->label('الكورس')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->label('إجمالي المبلغ')
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->label('المبلغ المدفوع')
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('الخصم')
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('remaining_amount')
                    ->label('المتبقي')
                    ->money('EGP')
                    ->state(fn ($record) => max(0, $record->total_amount - $record->paid_amount - $record->discount))
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success')
                    ->sortable(),
                TextColumn::make('payment_plan')
                    ->label('خطة الدفع')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'monthly' => 'شهري',
                        'quarterly' => 'ربع سنوي',
                        'full' => 'كاش (كامل)',
                        'installments' => 'أقساط',
                        'full_amount' => 'كاش (كامل)',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'partial' => 'جزئي',
                        'paid' => 'مدفوع',
                        'overdue' => 'متأخر',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'partial' => 'info',
                        'paid' => 'success',
                        'overdue' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('payments', [
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'الكورس' => fn ($r) => $r->course?->title ?? '',
                        'إجمالي المبلغ' => 'total_amount',
                        'المبلغ المدفوع' => 'paid_amount',
                        'الخصم' => 'discount',
                        'خطة الدفع' => 'payment_plan',
                        'الحالة' => 'status',
                    ]),
                ]),
            ]);
    }
}
