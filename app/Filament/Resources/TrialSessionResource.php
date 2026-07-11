<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrialSessionResource\Pages;
use App\Models\TrialSession;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ExportCsv;

class TrialSessionResource extends Resource
{
    protected static ?string $model = TrialSession::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static string|\UnitEnum|null $navigationGroup = 'الشؤون الأكاديمية';
    protected static ?string $navigationLabel = 'السيشن التجريبي';
    protected static ?string $pluralModelLabel = 'جلسات تجريبية';
    protected static ?string $modelLabel = 'جلسة تجريبية';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('student_name')
                    ->label('اسم الطالب')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('age')
                    ->label('العمر')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('parent_phone')
                    ->label('رقم هاتف ولي الأمر')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('session_date')
                    ->label('تاريخ الجلسة')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'attended' => 'حضر',
                        'subscribed' => 'اشترك',
                        'absent' => 'غائب',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_name')
                    ->label('اسم الطالب')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('العمر')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent_phone')
                    ->label('رقم الهاتف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('session_date')
                    ->label('التاريخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'attended' => 'info',
                        'subscribed' => 'success',
                        'absent' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    ExportCsv::make('trial_sessions', [
                        'اسم الطالب' => 'student_name',
                        'العمر' => 'age',
                        'رقم الهاتف' => 'parent_phone',
                        'التاريخ' => 'session_date',
                        'الحالة' => 'status',
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
            'index' => Pages\ListTrialSessions::route('/'),
            'create' => Pages\CreateTrialSession::route('/create'),
            'edit' => Pages\EditTrialSession::route('/{record}/edit'),
        ];
    }
}
