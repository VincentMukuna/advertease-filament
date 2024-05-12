<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class CampaignsChart extends ChartWidget
{
    protected static ?string $heading = 'Campaigns per month';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Campaigns',
                    'data' => [24, 34, 45, 33, 55, 57, 67, 87, 75, 85, 96, 89],
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
