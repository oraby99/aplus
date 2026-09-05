<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;
use Illuminate\Database\Eloquent\Builder;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable(),
                TextColumn::make('group.name')
                    ->label('المجموعة')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
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
                    ->state(fn ($record) => $record->remaining_amount)
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw("(total_amount - paid_amount - discount) {$direction}");
                    }),
                TextColumn::make('due_date_display')
                    ->label('موعد الاستحقاق')
                    ->state(function ($record) {
                        if ($record->remaining_amount <= 0 || $record->status === 'paid') {
                            return 'مسدد بالكامل';
                        }
                        $nextDue = $record->next_due_date;
                        if ($nextDue) {
                            $formatted = $nextDue->format('Y-m-d');
                            return $record->is_overdue ? "متأخر ({$formatted})" : $formatted;
                        }
                        return 'غير محدد';
                    })
                    ->badge()
                    ->color(function ($record) {
                        if ($record->remaining_amount <= 0 || $record->status === 'paid') {
                            return 'success';
                        }
                        if ($record->is_overdue) {
                            return 'danger';
                        }
                        if ($record->next_due_date) {
                            return 'warning';
                        }
                        return 'gray';
                    }),
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('due_status')
                    ->label('حالة الاستحقاق')
                    ->options([
                        'overdue' => 'المتأخرين عن السداد ⚠️',
                        'due_soon' => 'عليهم الدور (مستحق الدفع) ⏳',
                        'has_remaining' => 'متبقي عليهم مبالغ',
                        'fully_paid' => 'مسدد بالكامل ✅',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $val = $data['value'] ?? null;
                        if ($val === 'overdue') {
                            return $query->overdue();
                        }
                        if ($val === 'due_soon') {
                            return $query->dueSoon();
                        }
                        if ($val === 'has_remaining') {
                            return $query->hasRemaining();
                        }
                        if ($val === 'fully_paid') {
                            return $query->fullyPaid();
                        }
                        return $query;
                    }),
                SelectFilter::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('حالة السجل')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'partial' => 'جزئي',
                        'paid' => 'مدفوع',
                        'overdue' => 'متأخر',
                    ]),
            ])
            ->recordActions([
                Action::make('mark_paid')
                    ->label('سداد كامل')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->remaining_amount > 0)
                    ->requiresConfirmation()
                    ->modalHeading('تأكيد السداد الكامل')
                    ->modalDescription(fn ($record) => "هل تريد تأكيد سداد كامل المبلغ المتبقي ({$record->remaining_amount} ج.م) للطالب {$record->student?->name}؟")
                    ->action(function ($record) {
                        $record->update([
                            'paid_amount' => $record->total_amount - $record->discount,
                            'status' => 'paid',
                        ]);
                        $record->installments()->where('status', '!=', 'paid')->update([
                            'status' => 'paid',
                            'paid_date' => now(),
                        ]);
                        Notification::make()
                            ->title('تم تسجيل السداد بنجاح')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('payments', [
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'المجموعة' => fn ($r) => $r->group?->name ?? '',
                        'الكورس' => fn ($r) => $r->course?->title ?? '',
                        'إجمالي المبلغ' => 'total_amount',
                        'المبلغ المدفوع' => 'paid_amount',
                        'الخصم' => 'discount',
                        'المتبقي' => fn ($r) => $r->remaining_amount,
                        'موعد الاستحقاق' => fn ($r) => $r->next_due_date?->format('Y-m-d') ?? '—',
                        'خطة الدفع' => 'payment_plan',
                        'الحالة' => 'status',
                    ]),
                ]),
            ]);
    }
}
