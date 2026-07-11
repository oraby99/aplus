<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classSession.group.name')
                    ->label('المجموعة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classSession.session_date')
                    ->label('تاريخ الحصة')
                    ->date()
                    ->sortable(),
                TextColumn::make('classSession.topic')
                    ->label('موضوع الحصة')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'حاضر',
                        'absent' => 'غائب',
                        'late' => 'متأخر',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'late' => 'warning',
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
                    ExportCsv::make('attendance', [
                        'رقم الحصة' => fn ($r) => $r->classSession?->id ?? '',
                        'موضوع الحصة' => fn ($r) => $r->classSession?->topic ?? '',
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'الحالة' => fn ($r) => match($r->status) { 'present' => 'حاضر', 'absent' => 'غائب', 'late' => 'متأخر', default => $r->status },
                        'ملاحظات' => 'notes',
                    ]),
                ]),
            ]);
    }
}
