<?php

namespace App\Filament\Resources\ClassSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Exports\ExportCsv;

class ClassSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label('المجموعة')
                    ->searchable(),
                TextColumn::make('session_date')
                    ->label('تاريخ الحصة')
                    ->date()
                    ->sortable(),
                TextColumn::make('topic')
                    ->label('الموضوع')
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
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportCsv::make('class_sessions', [
                        'المجموعة' => fn ($r) => $r->group?->name ?? '',
                        'تاريخ الحصة' => 'session_date',
                        'الموضوع' => 'topic',
                    ]),
                ]),
            ]);
    }
}
