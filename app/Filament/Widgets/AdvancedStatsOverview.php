<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Payment;
use App\Models\TrialSession;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdvancedStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('الطلاب المسجلين', User::where('type', 'student')->count())
                ->description('إجمالي الطلاب في الأكاديمية')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('المشتركون الجدد (تجريبي)', TrialSession::where('status', 'subscribed')->count())
                ->description('مقارنة بإجمالي من حضر ' . TrialSession::where('status', 'attended')->count())
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
                
            Stat::make('الإيرادات المحصلة', Payment::where('status', 'paid')->sum('paid_amount') . ' ج.م')
                ->description('المدفوعات المتأخرة: ' . Payment::where('status', 'overdue')->count())
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
