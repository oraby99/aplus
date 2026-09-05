<?php

namespace App\Filament\Resources\Installments\Pages;

use App\Filament\Resources\Installments\InstallmentResource;
use App\Models\Installment;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListInstallments extends ListRecords
{
    protected static string $resource = InstallmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل')
                ->badge(Installment::count()),

            'overdue' => Tab::make('الأقساط المتأخرة ⚠️')
                ->badge(Installment::overdue()->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->overdue()),

            'due' => Tab::make('مستحقة قريباً ⏳')
                ->badge(Installment::dueSoon()->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->dueSoon()),

            'paid' => Tab::make('المدفوعة ✅')
                ->badge(Installment::paid()->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->paid()),
        ];
    }
}
