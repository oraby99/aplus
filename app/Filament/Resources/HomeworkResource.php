<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeworkResource\Pages;
use App\Models\Homework;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HomeworkResource extends Resource
{
    protected static ?string $model = Homework::class;

    protected static ?int $navigationSort = 8;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static string|\UnitEnum|null $navigationGroup = 'شؤون الطلاب';
    protected static ?string $navigationLabel = 'الواجبات والمشاريع';
    protected static ?string $pluralModelLabel = 'الواجبات والمشاريع';
    protected static ?string $modelLabel = 'تسليم واجب';

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        // Hidden from students: students manage homework inside their classroom
        if ($user->type === 'student') {
            return false;
        }

        return true;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['group', 'student', 'teacher']);

        if (auth()->user()?->type === 'teacher') {
            return $query->whereHas('group', fn ($q) => $q->where('teacher_id', auth()->id()));
        }

        if (auth()->user()?->type === 'student') {
            return $query->where('student_id', auth()->id());
        }

        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn (Builder $query) => $query->where('type', 'student'))
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('title')
                    ->label('عنوان الواجب / المشروع')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('file_path')
                    ->label('ملف الواجب المرفق')
                    ->disk('public')
                    ->directory('homeworks')
                    ->downloadable()
                    ->openable(),

                Forms\Components\TextInput::make('link_url')
                    ->label('رابط المشروع (إن وجد)')
                    ->url()
                    ->placeholder('https://scratch.mit.edu/projects/...'),

                Forms\Components\Textarea::make('description')
                    ->label('ملاحظات ووصف الطالب')
                    ->columnSpanFull(),

                Section::make('تقييم المهندس والتغذية الراجعة')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('حالة الواجب')
                            ->options([
                                'pending' => 'قيد المراجعة ⏳',
                                'approved' => 'معتمد وممتاز 🌟',
                                'needs_revision' => 'يحتاج تعديل ✏️',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\TextInput::make('score')
                            ->label('الدرجة (من 100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('/ 100'),

                        Forms\Components\Select::make('teacher_id')
                            ->label('المهندس المُقيِّم')
                            ->relationship('teacher', 'name', fn (Builder $query) => $query->where('type', 'teacher'))
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->user()?->type === 'teacher' ? auth()->id() : null),

                        Forms\Components\Textarea::make('feedback')
                            ->label('ملاحظات المهندس وتشجيع الطالب')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('group.name')
                    ->label('المجموعة')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان الواجب / المشروع')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('file_path')
                    ->label('الملف')
                    ->formatStateUsing(fn ($state) => $state ? '📥 تحميل الملف' : '—')
                    ->url(fn ($record) => $record->file_url)
                    ->openUrlInNewTab()
                    ->color(fn ($state) => $state ? 'primary' : 'gray'),

                Tables\Columns\TextColumn::make('link_url')
                    ->label('الرابط')
                    ->formatStateUsing(fn ($state) => $state ? '🔗 رابط المشروع' : '—')
                    ->url(fn ($record) => $record->link_url)
                    ->openUrlInNewTab()
                    ->color(fn ($state) => $state ? 'info' : 'gray'),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'needs_revision' => 'warning',
                        default => 'info',
                    })
                    ->formatStateUsing(fn ($record) => $record->status_label),

                Tables\Columns\TextColumn::make('score')
                    ->label('الدرجة')
                    ->formatStateUsing(fn ($state) => $state !== null ? "{$state} / 100" : '—')
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state === null => 'gray',
                        (int) $state >= 90 => 'success',
                        (int) $state >= 70 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('المهندس المُقيّم')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسليم')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة ⏳',
                        'approved' => 'معتمد وممتاز 🌟',
                        'needs_revision' => 'يحتاج تعديل ✏️',
                    ]),

                Tables\Filters\SelectFilter::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn (Builder $query) => $query->where('type', 'student'))
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('evaluate')
                    ->label('تقييم الواجب 📝')
                    ->icon('heroicon-o-pencil-square')
                    ->color('success')
                    ->modalHeading(fn ($record) => "تقييم واجب الطالب: {$record->student?->name}")
                    ->form([
                        Forms\Components\TextInput::make('score')
                            ->label('الدرجة (من 100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(fn ($record) => $record->score ?? 100)
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('حالة الواجب')
                            ->options([
                                'approved' => 'معتمد وممتاز 🌟',
                                'needs_revision' => 'يحتاج تعديل ✏️',
                                'pending' => 'قيد المراجعة ⏳',
                            ])
                            ->default(fn ($record) => $record->status === 'pending' ? 'approved' : $record->status)
                            ->required(),

                        Forms\Components\Textarea::make('feedback')
                            ->label('ملاحظات المهندس والتغذية الراجعة')
                            ->rows(3)
                            ->default(fn ($record) => $record->feedback),
                    ])
                    ->action(function (Homework $record, array $data): void {
                        $record->update([
                            'score' => $data['score'],
                            'status' => $data['status'],
                            'feedback' => $data['feedback'],
                            'teacher_id' => auth()->id(),
                            'evaluated_at' => now(),
                        ]);

                        Notification::make()
                            ->title('تم حفظ تقييم الواجب بنجاح ✨')
                            ->success()
                            ->send();
                    }),

                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeworks::route('/'),
            'create' => Pages\CreateHomework::route('/create'),
            'edit' => Pages\EditHomework::route('/{record}/edit'),
        ];
    }
}
