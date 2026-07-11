<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Group;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي الطلاب', User::where('type', 'student')->count())
                ->description('إجمالي الطلاب المسجلين')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
                
            Stat::make('إجمالي المعلمين', User::where('type', 'teacher')->count())
                ->description('المعلمين المتاحين بالنظام')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
                
            Stat::make('المجموعات النشطة', Group::count())
                ->description('إجمالي المجموعات')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
                
            Stat::make('إجمالي التحصيلات', number_format(Payment::sum('paid_amount')) . ' ج.م')
                ->description('المبالغ التي تم تحصيلها')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
