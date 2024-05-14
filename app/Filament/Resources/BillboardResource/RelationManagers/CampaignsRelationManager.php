<?php

namespace App\Filament\Resources\BillboardResource\RelationManagers;

use App\Filament\Resources\BillboardResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CampaignsRelationManager extends RelationManager
{
    protected static string $relationship = 'campaigns';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function form(Form $form): Form
    {
        return BillboardResource::form($form);
    }

    public function table(Table $table): Table
    {
        return BillboardResource::table($table);
    }
}
