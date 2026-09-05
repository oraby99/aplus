<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label('المجموعة')
                    ->searchable()
                    ->sortable()
                    ->default(fn ($record) => $record->classSession?->group?->name ?? '—'),
                TextColumn::make('classSession.session_date')
                    ->label('تاريخ الحصة')
                    ->date()
                    ->sortable(),
                TextColumn::make('classSession.topic')
                    ->label('موضوع الحصة')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable()
                    ->description(function ($record) {
                        $student = $record->student;
                        if (!$student) return null;
                        $total = $student->total_sessions ?: 24;
                        $attended = $student->attended_sessions_count;
                        $remaining = max(0, $total - $attended);
                        return "حضر {$attended} من {$total} (باقي {$remaining})";
                    }),
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
                TextColumn::make('student_balance')
                    ->label('رصيد الحصص (من 24)')
                    ->badge()
                    ->state(function ($record) {
                        $student = $record->student;
                        if (!$student) return '—';
                        $total = $student->total_sessions ?: 24;
                        $attended = $student->attended_sessions_count;
                        $remaining = max(0, $total - $attended);
                        return "{$attended} / {$total} (باقي {$remaining})";
                    })
                    ->color(function ($record) {
                        $student = $record->student;
                        if (!$student) return 'gray';
                        $total = $student->total_sessions ?: 24;
                        $attended = $student->attended_sessions_count;
                        if ($attended >= $total) return 'danger';
                        if ($attended >= ($total - 4)) return 'warning';
                        return 'success';
                    }),
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
                SelectFilter::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name', function ($query) {
                        if (auth()->user()?->type === 'teacher') {
                            return $query->where('teacher_id', auth()->id());
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'present' => 'حاضر',
                        'absent' => 'غائب',
                        'late' => 'متأخر',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('attendance', [
                        'المجموعة' => fn ($r) => $r->group?->name ?? $r->classSession?->group?->name ?? '',
                        'رقم الحصة' => fn ($r) => $r->classSession?->id ?? '',
                        'تاريخ الحصة' => fn ($r) => $r->classSession?->session_date?->format('Y-m-d') ?? '',
                        'موضوع الحصة' => fn ($r) => $r->classSession?->topic ?? '',
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'رصيد الحصص (من 24)' => fn ($r) => $r->student ? ($r->student->attended_sessions_count . ' من ' . ($r->student->total_sessions ?: 24) . ' (باقي ' . $r->student->remaining_sessions_count . ')') : '',
                        'الحالة' => fn ($r) => match($r->status) { 'present' => 'حاضر', 'absent' => 'غائب', 'late' => 'متأخر', default => $r->status },
                        'ملاحظات' => 'notes',
                    ]),
                ]),
            ]);
    }
}
