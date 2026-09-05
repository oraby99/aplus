<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'شؤون الطلاب';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return 'طالب';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الطلاب المشتركين';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', 'student')
            ->withCount([
                'attendances as attended_count' => fn ($q) => $q->whereIn('status', ['present', 'late']),
                'attendances as absent_count' => fn ($q) => $q->where('status', 'absent'),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                SchemaComponents\Section::make('البيانات الأساسية للطفل')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone')
                            ->label('رقم هاتف الطفل')
                            ->required(),
                        Forms\Components\TextInput::make('total_sessions')
                            ->label('إجمالي الحصص المقررة')
                            ->numeric()
                            ->default(24)
                            ->minValue(1)
                            ->helperText('الافتراضي 24 حصة لكل طالب. يمكنك زيادتها عند تجديد الاشتراك.')
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->required()
                            ->default(true),
                        Forms\Components\Hidden::make('type')
                            ->default('student'),
                    ])->columns(2),

                SchemaComponents\Section::make('معلومات ولي الأمر والدراسة')
                    ->schema([
                        Forms\Components\TextInput::make('parent_name')
                            ->label('اسم ولي الأمر')
                            ->required(),
                        Forms\Components\TextInput::make('parent_phone')
                            ->label('رقم هاتف ولي الأمر')
                            ->required(),
                        Forms\Components\TextInput::make('age')
                            ->label('العمر')
                            ->numeric()
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('تاريخ الميلاد'),
                        Forms\Components\TextInput::make('school')
                            ->label('المدرسة'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendance_progress')
                    ->label('رصيد الحصص (من 24)')
                    ->badge()
                    ->state(function (User $record) {
                        $total = $record->total_sessions ?: 24;
                        $attended = $record->attended_count ?? $record->attended_sessions_count;
                        $remaining = max(0, $total - $attended);
                        return "حضر {$attended} من {$total} (باقي {$remaining})";
                    })
                    ->color(function (User $record) {
                        $total = $record->total_sessions ?: 24;
                        $attended = $record->attended_count ?? $record->attended_sessions_count;
                        if ($attended >= $total) return 'danger';
                        if ($attended >= ($total - 4)) return 'warning';
                        if ($attended > 0) return 'success';
                        return 'gray';
                    })
                    ->description(function (User $record) {
                        $absent = $record->absent_count ?? $record->absent_sessions_count;
                        $percent = $record->attendance_percentage;
                        return "غياب: {$absent} | إنجاز: {$percent}%";
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('attended_count', $direction);
                    }),
                Tables\Columns\TextColumn::make('age')
                    ->label('العمر')
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent_name')
                    ->label('ولي الأمر')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent_phone')
                    ->label('هاتف ولي الأمر')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة (نشط/غير نشط)'),
                Tables\Filters\SelectFilter::make('attendance_status')
                    ->label('حالة رصيد الـ 24 حصة')
                    ->options([
                        'completed' => '🎉 أتم الـ 24 حصة بالكامل',
                        'approaching' => '⚠️ شارف على الانتهاء (20-23 حصة)',
                        'ongoing' => '🚀 مستمر في الحضور (1-19 حصة)',
                        'not_started' => '⚪ لم يحضر أي حصة (0)',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $value = $data['value'] ?? null;
                        if (!$value) return $query;

                        $attendedSql = "(SELECT COUNT(*) FROM attendances WHERE attendances.student_id = users.id AND attendances.status IN ('present', 'late'))";

                        return match ($value) {
                            'completed' => $query->whereRaw("{$attendedSql} >= COALESCE(users.total_sessions, 24)"),
                            'approaching' => $query->whereRaw("{$attendedSql} >= (COALESCE(users.total_sessions, 24) - 4) AND {$attendedSql} < COALESCE(users.total_sessions, 24)"),
                            'ongoing' => $query->whereRaw("{$attendedSql} > 0 AND {$attendedSql} < (COALESCE(users.total_sessions, 24) - 4)"),
                            'not_started' => $query->whereRaw("{$attendedSql} = 0"),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                Action::make('attendance_details')
                    ->label('متابعة الحصص 🎯')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->modalHeading(fn (User $record) => "سجل ورصيد الحصص للطالب: {$record->name}")
                    ->modalIcon('heroicon-o-academic-cap')
                    ->modalWidth('5xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('إغلاق')
                    ->modalContent(function (User $record) {
                        $record->load(['attendances.classSession.group', 'payments.course', 'payments.installments']);
                        return view('filament.components.student-attendance-modal', [
                            'student' => $record,
                        ]);
                    }),
                Action::make('print_report')
                    ->label('طباعة التقرير 🖨️')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn ($record) => route('student.report', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('students', [
                        'الاسم' => 'name',
                        'العمر' => 'age',
                        'اسم ولي الأمر' => 'parent_name',
                        'هاتف ولي الأمر' => 'parent_phone',
                        'إجمالي الحصص المقررة' => fn ($r) => $r->total_sessions ?: 24,
                        'الحصص المحضورة' => fn ($r) => $r->attended_sessions_count,
                        'الحصص المتبقية' => fn ($r) => $r->remaining_sessions_count,
                        'مرات الغياب' => fn ($r) => $r->absent_sessions_count,
                        'تاريخ الميلاد' => 'birth_date',
                        'المدرسة' => 'school',
                        'البريد الإلكتروني' => 'email',
                        'رقم الهاتف' => 'phone',
                        'نشط' => fn ($r) => $r->is_active ? 'نعم' : 'لا',
                    ]),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
