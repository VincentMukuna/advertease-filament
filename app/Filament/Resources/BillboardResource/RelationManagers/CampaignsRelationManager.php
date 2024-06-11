<?php

namespace App\Filament\Resources\BillboardResource\RelationManagers;

use App\Filament\Resources\CampaignResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class CampaignsRelationManager extends RelationManager
{
    protected static string $relationship = 'campaigns';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Campaign Title')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                //                Forms\Components\ToggleButtons::make('status')
                //                    ->options(BillboardCampaignStatus::class)
                //                    ->inline(),
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Start Maintenance'),

                ])->alignEnd(),
            ])

            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ...CampaignResource::getDetails(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),

                ...CampaignResource::getDurationDetails(),
                ...CampaignResource::getBrandDetails(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth(MaxWidth::Large),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
