<?php

namespace App\Filament\Resources\Installments\Tables;

use App\Filament\Exports\ExportCsv;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InstallmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment.student.name')
                    ->label('الطالب')
                    ->searchable(),
                TextColumn::make('payment.group.name')
                    ->label('المجموعة')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('payment.course.title')
                    ->label('الكورس')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('المبلغ')
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('تاريخ الاستحقاق')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => ($record->status !== 'paid' && $record->is_overdue) ? 'danger' : null),
                TextColumn::make('paid_date')
                    ->label('تاريخ الدفع')
                    ->date()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->state(fn ($record) => $record->effective_status)
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوع ✅',
                        'overdue' => 'متأخر ⚠️',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
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
                SelectFilter::make('installment_status')
                    ->label('حالة القسط')
                    ->options([
                        'overdue' => 'الأقساط المتأخرة ⚠️',
                        'due_soon' => 'مستحق قريباً ⏳',
                        'paid' => 'مدفوع بالكامل ✅',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $val = $data['value'] ?? null;
                        if ($val === 'overdue') {
                            return $query->overdue();
                        }
                        if ($val === 'due_soon') {
                            return $query->dueSoon();
                        }
                        if ($val === 'paid') {
                            return $query->paid();
                        }
                        return $query;
                    }),
                SelectFilter::make('group')
                    ->label('المجموعة')
                    ->relationship('payment.group', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('course')
                    ->label('الكورس')
                    ->relationship('payment.course', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                Action::make('mark_paid')
                    ->label('تسجيل السداد 💵')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== 'paid')
                    ->requiresConfirmation()
                    ->modalHeading('تأكيد سداد القسط')
                    ->modalDescription(fn ($record) => "هل تريد تأكيد سداد هذا القسط بمبلغ ({$record->amount} ج.م) للطالب {$record->payment?->student?->name}؟")
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'paid',
                            'paid_date' => now(),
                        ]);
                        Notification::make()
                            ->title('تم تسجيل سداد القسط بنجاح')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('installments', [
                        'الطالب' => fn ($r) => $r->payment?->student?->name ?? '',
                        'المجموعة' => fn ($r) => $r->payment?->group?->name ?? '',
                        'الكورس' => fn ($r) => $r->payment?->course?->title ?? '',
                        'مبلغ القسط' => 'amount',
                        'تاريخ الاستحقاق' => fn ($r) => $r->due_date?->format('Y-m-d') ?? '',
                        'تاريخ الدفع' => fn ($r) => $r->paid_date?->format('Y-m-d') ?? '',
                        'الحالة' => fn ($r) => match($r->effective_status) { 'paid' => 'مدفوع', 'overdue' => 'متأخر', default => 'قيد الانتظار' },
                    ]),
                ]),
            ]);
    }
}
