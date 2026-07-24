<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\ChartWidget;

class EnrollmentChart extends ChartWidget
{
    protected ?string $heading = 'مخطط الاشتراكات الطلابية الجديدة شهرياً';
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()->type === 'admin';
    }

    protected function getData(): array
    {
        $currentYear = date('Y');
        
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = Enrollment::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'الاشتراكات الجديدة الكلية',
                    'data' => $data,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.8)',
                    'borderColor' => 'rgba(217, 119, 6, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
