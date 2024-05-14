<?php

namespace App\Filament\Resources\BrandResource\RelationManagers;

use App\Filament\Resources\CampaignResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CampaignsRelationManager extends RelationManager
{
    protected static string $relationship = 'campaigns';

    public function form(Form $form): Form
    {
        return CampaignResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColumnGroup::make('Details')
                    ->columns([
                        Tables\Columns\TextColumn::make('number')
                            ->searchable()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('title')
                            ->limit(30)
                            ->searchable(),
                        Tables\Columns\TextColumn::make('budget')
                            ->numeric()
                            ->summarize([
                                Tables\Columns\Summarizers\Sum::make(),
                                Tables\Columns\Summarizers\Average::make(),
                            ])
                            ->sortable(),
                        Tables\Columns\TextColumn::make('target_audience')
                            ->limit(25)
                            ->searchable(),
                    ]),
                Tables\Columns\ColumnGroup::make('Duration')
                    ->columns([
                        Tables\Columns\TextColumn::make('start_date')
                            ->date()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('end_date')
                            ->date()
                            ->sortable(),
                    ]),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
