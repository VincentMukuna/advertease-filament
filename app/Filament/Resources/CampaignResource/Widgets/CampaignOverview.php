<?php

namespace App\Filament\Resources\CampaignResource\Widgets;

use App\Filament\Resources\CampaignResource\Pages\ListCampaigns;
use App\Models\Campaign;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CampaignOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static bool $isLazy = false;

    protected function getTablePage(): string
    {
        return ListCampaigns::class;
    }

    protected function getStats(): array
    {
        $campaignData = Trend::model(Campaign::class)
            ->between(
                start: now()->subYear(),
                end: now()
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Campaigns', $this->getPageTableQuery()->count())
                ->chart(
                    $campaignData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make('Ongoing Campaigns', $this->getPageTableQuery()->where('end_date', '>=', now())->count()),
            Stat::make('Average Budget', number_format($this->getPageTableQuery()->average('budget'), 2)),

        ];
    }
}
