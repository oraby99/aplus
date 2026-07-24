<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'مخطط الإيرادات الشهرية (ج.م)';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->user()->type === 'admin';
    }

    protected function getData(): array
    {
        $currentYear = date('Y');
        
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $sum = Payment::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('paid_amount');
            $data[] = (float) $sum;
        }

        return [
            'datasets' => [
                [
                    'label' => 'الإيرادات المحصلة',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'borderWidth' => 3,
                    'fill' => true,
                ],
            ],
            'labels' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
