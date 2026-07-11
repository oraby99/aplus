<?php

namespace App\Filament\Resources\Installments;

use App\Filament\Resources\Installments\Pages\CreateInstallment;
use App\Filament\Resources\Installments\Pages\EditInstallment;
use App\Filament\Resources\Installments\Pages\ListInstallments;
use App\Filament\Resources\Installments\Schemas\InstallmentForm;
use App\Filament\Resources\Installments\Tables\InstallmentsTable;
use App\Models\Installment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class InstallmentResource extends Resource
{
    protected static ?int $navigationSort = 9;

    protected static ?string $model = Installment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string|\UnitEnum|null $navigationGroup = 'المالية';

    public static function getModelLabel(): string
    {
        return 'قسط';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الأقساط';
    }

    public static function form(Schema $schema): Schema
    {
        return InstallmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstallmentsTable::configure($table);
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
            'index' => ListInstallments::route('/'),
            'create' => CreateInstallment::route('/create'),
            'edit' => EditInstallment::route('/{record}/edit'),
        ];
    }
}
