<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Payment;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

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
                ->badge(Payment::count()),

            'overdue' => Tab::make('المتأخرين ⚠️')
                ->badge(Payment::overdue()->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->overdue()),

            'due' => Tab::make('عليهم الدور (مستحق) ⏳')
                ->badge(Payment::dueSoon()->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->dueSoon()),

            'remaining' => Tab::make('متبقي عليهم مبالغ')
                ->badge(Payment::hasRemaining()->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->hasRemaining()),

            'paid' => Tab::make('مسدد بالكامل ✅')
                ->badge(Payment::fullyPaid()->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->fullyPaid()),
        ];
    }
}
