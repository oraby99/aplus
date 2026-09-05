<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state) {
                            $group = Group::with('level.course')->find($state);
                            if ($group?->level?->course_id) {
                                $set('course_id', $group->level->course_id);
                                if ($group->level->course?->price && (float)$get('total_amount') == 0) {
                                    $set('total_amount', $group->level->course->price);
                                }
                            }
                        }
                    }),
                Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', function ($query, callable $get) {
                        $query->where('type', 'student');
                        if ($groupId = $get('group_id')) {
                            $query->whereHas('enrollments', fn ($q) => $q->where('group_id', $groupId));
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state && empty($get('group_id'))) {
                            $firstGroupId = Enrollment::where('student_id', $state)
                                ->where('status', 'active')
                                ->value('group_id');
                            if ($firstGroupId) {
                                $set('group_id', $firstGroupId);
                                $group = Group::with('level.course')->find($firstGroupId);
                                if ($group?->level?->course_id) {
                                    $set('course_id', $group->level->course_id);
                                    if ($group->level->course?->price && (float)$get('total_amount') == 0) {
                                        $set('total_amount', $group->level->course->price);
                                    }
                                }
                            }
                        }
                    }),
                Select::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state) {
                            $course = Course::find($state);
                            if ($course?->price && (float)$get('total_amount') == 0) {
                                $set('total_amount', $course->price);
                            }
                        }
                    }),
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
                \Filament\Forms\Components\DatePicker::make('due_date')
                    ->label('تاريخ الاستحقاق')
                    ->placeholder('اختياري - موعد السداد القادم'),
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
