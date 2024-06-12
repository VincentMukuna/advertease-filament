<?php

namespace App\Filament\Widgets;

use App\Models\BillboardOwner;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class TotalBillboardOwners extends ChartWidget
{
    protected static ?string $heading = 'Total Billboard Owners';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '200px';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $owners = Trend::model(BillboardOwner::class)->perMonth()->between(start: now()->startOfYear(), end: now())->count();

        return [
            'datasets' => [
                [
                    'label' => 'Brands',
                    'data' => $owners->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                ],
            ],
            'labels' => $owners->map(fn (TrendValue $value) => Carbon::make($value->date)->shortEnglishMonth),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
