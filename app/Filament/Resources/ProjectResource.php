<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ExportCsv;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-light-bulb';
    protected static string|\UnitEnum|null $navigationGroup = 'شؤون الطلاب';
    protected static ?string $navigationLabel = 'المشاريع';
    protected static ?string $pluralModelLabel = 'المشاريع';
    protected static ?string $modelLabel = 'مشروع';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn (Builder $query) => $query->where('type', 'student'))
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title')
                    ->nullable(),
                Forms\Components\TextInput::make('title')
                    ->label('عنوان المشروع')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('project_url')
                    ->label('رابط المشروع')
                    ->url()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image_path')
                    ->label('صورة للمشروع')
                    ->image()
                    ->directory('projects'),
                Forms\Components\Textarea::make('description')
                    ->label('وصف المشروع')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('image_path')
                    ->label('الصورة')
                    ->html()
                    ->state(fn ($record) => $record->image_path 
                        ? '<img src="' . (\Illuminate\Support\Str::startsWith($record->image_path, ['http://', 'https://']) ? $record->image_path : asset('storage/' . $record->image_path)) . '" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; display: inline-block;" />'
                        : '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; border: 2px solid #e2e8f0; font-size: 20px;">💻</div>'
                    ),
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان المشروع')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('الطالب')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('الكورس')
                    ->sortable(),
                Tables\Columns\TextColumn::make('project_url')
                    ->label('رابط المشروع')
                    ->url(fn ($record) => $record->project_url)
                    ->color('primary')
                    ->openUrlInNewTab()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('student_id')
                    ->label('الطالب')
                    ->relationship('student', 'name', fn (Builder $query) => $query->where('type', 'student')),
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title'),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportCsv::make('projects', [
                        'عنوان المشروع' => 'title',
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'الكورس' => fn ($r) => $r->course?->title ?? '',
                        'رابط المشروع' => 'project_url',
                        'الوصف' => 'description',
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
