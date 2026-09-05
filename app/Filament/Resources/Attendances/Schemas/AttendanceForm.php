<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\Enrollment;
use App\Models\Group;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name', function ($query) {
                        if (auth()->user()?->type === 'teacher') {
                            return $query->where('teacher_id', auth()->id());
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('class_session_id', null);
                        $set('student_id', null);
                    }),
                Select::make('class_session_id')
                    ->label('الحصة')
                    ->required()
                    ->searchable()
                    ->live()
                    ->options(function (callable $get) {
                        $groupId = $get('group_id');
                        $query = ClassSession::query();
                        if ($groupId) {
                            $query->where('group_id', $groupId);
                        } elseif (auth()->user()?->type === 'teacher') {
                            $query->whereHas('group', fn ($q) => $q->where('teacher_id', auth()->id()));
                        }
                        return $query->latest('session_date')
                            ->get()
                            ->mapWithKeys(function ($session) use ($groupId) {
                                $date = $session->session_date ? $session->session_date->format('Y-m-d') : 'بدون تاريخ';
                                $topic = $session->topic ? " - {$session->topic}" : '';
                                $groupName = (!$groupId && $session->group) ? " [{$session->group->name}]" : '';
                                return [$session->id => "{$date}{$topic}{$groupName} (حصة #{$session->id})"];
                            });
                    })
                    ->createOptionForm([
                        DatePicker::make('session_date')
                            ->label('تاريخ الحصة')
                            ->default(now())
                            ->required(),
                        TextInput::make('topic')
                            ->label('موضوع الحصة')
                            ->placeholder('مثال: مقدمة في بايثون'),
                    ])
                    ->createOptionUsing(function (array $data, callable $get) {
                        $groupId = $get('group_id');
                        if (!$groupId) {
                            throw new \Exception('يرجى اختيار المجموعة أولاً قبل إنشاء حصة جديدة.');
                        }
                        return ClassSession::create([
                            'group_id' => $groupId,
                            'session_date' => $data['session_date'],
                            'topic' => $data['topic'] ?? null,
                        ])->id;
                    })
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state && empty($get('group_id'))) {
                            $session = ClassSession::find($state);
                            if ($session?->group_id) {
                                $set('group_id', $session->group_id);
                            }
                        }
                    }),
                Select::make('student_id')
                    ->label('الطالب')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->helperText('إذا كان الطالب مسجلاً مسبقاً في هذه الحصة، سيتم تحديث حالته وملاحظاته دون تكرار.')
                    ->options(function (callable $get, $record) {
                        $groupId = $get('group_id');
                        $sessionId = $get('class_session_id');

                        $query = User::where('type', 'student')->where('is_active', true);
                        if ($groupId) {
                            $studentIds = Enrollment::where('group_id', $groupId)
                                ->pluck('student_id');
                            $query->whereIn('id', $studentIds);
                        }

                        $students = $query->pluck('name', 'id');

                        if ($sessionId) {
                            $recordedStudentIds = Attendance::where('class_session_id', $sessionId)
                                ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                                ->pluck('student_id')
                                ->toArray();

                            return $students->map(function ($name, $id) use ($recordedStudentIds) {
                                if (in_array($id, $recordedStudentIds)) {
                                    return "{$name} (مسجل مسبقاً ✔)";
                                }
                                return $name;
                            });
                        }

                        return $students;
                    })
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state && ($sessionId = $get('class_session_id'))) {
                            $existing = Attendance::where('class_session_id', $sessionId)
                                ->where('student_id', $state)
                                ->first();
                            if ($existing) {
                                $set('status', $existing->status);
                                if ($existing->notes) {
                                    $set('notes', $existing->notes);
                                }
                            }
                        }
                    }),
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
