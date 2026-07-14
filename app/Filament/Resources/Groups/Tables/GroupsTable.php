<?php

namespace App\Filament\Resources\Groups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;

class GroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('level.name')
                    ->label('المرحلة')
                    ->searchable(),
                TextColumn::make('teacher.name')
                    ->label('المعلم')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('max_students')
                    ->label('الحد الأقصى للطلاب')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('schedule')
                    ->label('الجدول')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('classroom')
                    ->label('الفصل الافتراضي')
                    ->icon('heroicon-o-video-camera')
                    ->color('success')
                    ->url(fn (\App\Models\Group $record): string => \App\Filament\Resources\Groups\GroupResource::getUrl('classroom', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('groups', [
                        'المرحلة' => fn ($r) => $r->level?->name ?? '',
                        'المعلم' => fn ($r) => $r->teacher?->name ?? '',
                        'الاسم' => 'name',
                        'الحد الأقصى للطلاب' => 'max_students',
                        'الجدول' => 'schedule',
                    ]),
                ]),
            ]);
    }
}
