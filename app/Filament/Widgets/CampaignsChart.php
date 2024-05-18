<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class CampaignsChart extends ChartWidget
{
    protected static ?string $heading = 'Campaigns this year';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $campaignsData = Trend::model(Campaign::class)
            ->between(
                start: now()->startOfYear(),
                end: now()

            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Campaigns',

                    'data' => $campaignsData->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                ],
            ],
            'labels' => $campaignsData->map(fn (TrendValue $value) => Carbon::make($value->date)->shortEnglishMonth),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
