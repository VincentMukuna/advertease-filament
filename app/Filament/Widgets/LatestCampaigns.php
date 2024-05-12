<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CampaignResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestCampaigns extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {

        return $table
            ->query(
                CampaignResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('budget')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_audience')
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->limit(30)
                    ->numeric()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (CampaignResource $record): string => CampaignResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
