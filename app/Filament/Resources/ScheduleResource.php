<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ExportCsv;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static string|\UnitEnum|null $navigationGroup = 'الشؤون الأكاديمية';
    protected static ?string $navigationLabel = 'جداول المهندسين';
    protected static ?string $pluralModelLabel = 'جداول المهندسين';
    protected static ?string $modelLabel = 'جدول';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('teacher_id')
                    ->label('المهندس')
                    ->relationship('teacher', 'name', fn (Builder $query) => $query->where('type', 'teacher'))
                    ->required(),
                Forms\Components\Select::make('group_id')
                    ->label('المجموعة')
                    ->relationship('group', 'name')
                    ->required(),
                Forms\Components\Select::make('day_of_week')
                    ->label('اليوم')
                    ->options([
                        'Saturday' => 'السبت',
                        'Sunday' => 'الأحد',
                        'Monday' => 'الإثنين',
                        'Tuesday' => 'الثلاثاء',
                        'Wednesday' => 'الأربعاء',
                        'Thursday' => 'الخميس',
                        'Friday' => 'الجمعة',
                    ])
                    ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label('وقت البدء')
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->label('وقت الانتهاء')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('المهندس')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->label('المجموعة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('اليوم')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Saturday' => 'السبت',
                        'Sunday' => 'الأحد',
                        'Monday' => 'الإثنين',
                        'Tuesday' => 'الثلاثاء',
                        'Wednesday' => 'الأربعاء',
                        'Thursday' => 'الخميس',
                        'Friday' => 'الجمعة',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('وقت البدء')
                    ->time('g:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('وقت الانتهاء')
                    ->time('g:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->label('المهندس')
                    ->relationship('teacher', 'name', fn (Builder $query) => $query->where('type', 'teacher')),
                Tables\Filters\SelectFilter::make('day_of_week')
                    ->label('اليوم')
                    ->options([
                        'Saturday' => 'السبت',
                        'Sunday' => 'الأحد',
                        'Monday' => 'الإثنين',
                        'Tuesday' => 'الثلاثاء',
                        'Wednesday' => 'الأربعاء',
                        'Thursday' => 'الخميس',
                        'Friday' => 'الجمعة',
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportCsv::make('schedules', [
                        'المجموعة' => fn ($r) => $r->group?->name ?? '',
                        'المهندس' => fn ($r) => $r->teacher?->name ?? '',
                        'اليوم' => fn ($r) => match($r->day_of_week) {
                            'Saturday' => 'السبت',
                            'Sunday' => 'الأحد',
                            'Monday' => 'الإثنين',
                            'Tuesday' => 'الثلاثاء',
                            'Wednesday' => 'الأربعاء',
                            'Thursday' => 'الخميس',
                            'Friday' => 'الجمعة',
                            default => $r->day_of_week
                        },
                        'وقت البدء' => 'start_time',
                        'وقت الانتهاء' => 'end_time',
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
