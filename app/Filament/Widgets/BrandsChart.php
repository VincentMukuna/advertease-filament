<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class BrandsChart extends ChartWidget
{
    protected static ?string $heading = 'Total Brands';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $brandsData = Trend::model(Brand::class)->perMonth()->between(start: now()->startOfYear(), end: now())->count();

        return [
            'datasets' => [
                [
                    'label' => 'Brands',
                    'data' => $brandsData->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                ],
            ],
            'labels' => $brandsData->map(fn (TrendValue $value) => Carbon::make($value->date)->shortEnglishMonth),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
