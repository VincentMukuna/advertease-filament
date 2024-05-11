<?php

namespace App\Filament\Resources\BillboardOwnerResource\Pages;

use App\Filament\Resources\BillboardOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBillboardOwner extends EditRecord
{
    protected static string $resource = BillboardOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
