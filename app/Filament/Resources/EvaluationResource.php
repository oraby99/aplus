<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluationResource\Pages;
use App\Models\Evaluation;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ExportCsv;

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';
    protected static string|\UnitEnum|null $navigationGroup = 'شؤون الطلاب';
    protected static ?string $navigationLabel = 'التقييمات';
    protected static ?string $pluralModelLabel = 'التقييمات';
    protected static ?string $modelLabel = 'تقييم';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user()?->type === 'teacher') {
            return $query->where('teacher_id', auth()->id());
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn (Builder $query) => $query->where('type', 'student'))
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label('المهندس المُقيِّم')
                    ->relationship('teacher', 'name', fn (Builder $query) => $query->where('type', 'teacher'))
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\DatePicker::make('evaluation_date')
                    ->label('تاريخ التقييم')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('score')
                    ->label('الدرجة')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('/ 100'),
                Forms\Components\Textarea::make('feedback')
                    ->label('ملاحظات الأداء')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('الطالب')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('الكورس')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('المهندس')
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('الدرجة')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('evaluation_date')
                    ->label('التاريخ')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title'),
                Tables\Filters\SelectFilter::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn (Builder $query) => $query->where('type', 'student')),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportCsv::make('evaluations', [
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'الكورس' => fn ($r) => $r->course?->title ?? '',
                        'المهندس' => fn ($r) => $r->teacher?->name ?? '',
                        'الدرجة' => 'score',
                        'التاريخ' => 'evaluation_date',
                        'ملاحظات' => 'notes',
                    ]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluations::route('/'),
            'create' => Pages\CreateEvaluation::route('/create'),
            'edit' => Pages\EditEvaluation::route('/{record}/edit'),
        ];
    }
}
