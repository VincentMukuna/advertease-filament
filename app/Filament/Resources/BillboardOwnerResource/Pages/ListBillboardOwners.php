<?php

namespace App\Filament\Resources\BillboardOwnerResource\Pages;

use App\Filament\Resources\BillboardOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBillboardOwners extends ListRecords
{
    protected static string $resource = BillboardOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
