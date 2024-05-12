<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListCampaigns extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = CampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CampaignResource\Widgets\CampaignOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'ongoing' => Tab::make()->query(fn ($query) => $query->where('end_date', '>', now())),
            'completed' => Tab::make()->query(fn ($query) => $query->where('end_date', '<', now())),
        ];
    }
}
