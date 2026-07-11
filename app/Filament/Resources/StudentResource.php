<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Schemas\Schema;
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
        return parent::getEloquentQuery()->where('type', 'student');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('البيانات الأساسية للطفل')
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

                Forms\Components\Section::make('معلومات ولي الأمر والدراسة')
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
            ])
            ->actions([
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

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->type, ['admin', 'teacher']);
    }
}
