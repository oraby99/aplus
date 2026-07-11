<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ExportCsv;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static string|\UnitEnum|null $navigationGroup = 'شؤون الطلاب';
    protected static ?string $navigationLabel = 'الشهادات';
    protected static ?string $pluralModelLabel = 'الشهادات';
    protected static ?string $modelLabel = 'شهادة';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user()?->type === 'teacher') {
            return $query->whereHas('student.enrollments.group', fn($q) => $q->where('teacher_id', auth()->id()));
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
                Forms\Components\Select::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('serial_number')
                    ->label('الرقم التسلسلي للشهادة')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => 'CERT-' . strtoupper(uniqid())),
                Forms\Components\DatePicker::make('issue_date')
                    ->label('تاريخ الإصدار')
                    ->required()
                    ->default(now()),
                Forms\Components\FileUpload::make('file_path')
                    ->label('ملف الشهادة (PDF/Image)')
                    ->directory('certificates')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('الرقم التسلسلي')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('الطالب')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('الكورس')
                    ->sortable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->label('تاريخ الإصدار')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('الكورس')
                    ->relationship('course', 'title'),
            ])
            ->actions([
                \Filament\Actions\Action::make('view_certificate')
                    ->label('عرض الشهادة 🎖️')
                    ->icon('heroicon-o-eye')
                    ->color('success')
                    ->url(fn ($record) => url('/certificate/' . $record->serial_number))
                    ->openUrlInNewTab(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportCsv::make('certificates', [
                        'الرقم التسلسلي' => 'serial_number',
                        'الطالب' => fn ($r) => $r->student?->name ?? '',
                        'الكورس' => fn ($r) => $r->course?->title ?? '',
                        'تاريخ الإصدار' => 'issue_date',
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
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
