<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BrandsChart extends ChartWidget
{
    protected static ?string $heading = 'Total Brands';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => [43, 56, 67, 78, 89, 93, 103, 105, 136, 143, 157, 173],
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
