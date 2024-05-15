<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use App\Enum\Billboard\BookingStatus;
use App\Filament\Resources\BillboardResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BillboardsRelationManager extends RelationManager
{
    protected static string $relationship = 'billboards';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColumnGroup::make('Details')->columns([

                    Tables\Columns\TextColumn::make('title')
                        ->limit(30)
                        ->searchable(),
                    Tables\Columns\SpatieMediaLibraryImageColumn::make('billboard-image')
                        ->label('Image')
                        ->alignCenter()
                        ->collection('billboard-images'),
                    Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->searchable(),
                ]),
                Tables\Columns\ColumnGroup::make('Statistics')->columns([
                    Tables\Columns\TextColumn::make('daily_rate')
                        ->numeric()
                        ->summarize([
                            Tables\Columns\Summarizers\Average::make()->label('Average Daily Rate'),
                        ])
                        ->sortable(),
                    Tables\Columns\TextColumn::make('size')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('type')
                        ->badge()
                        ->searchable(),

                    Tables\Columns\TextColumn::make('reach')
                        ->numeric()
                        ->summarize([
                            Tables\Columns\Summarizers\Sum::make()->label('Total Reach'),
                            Tables\Columns\Summarizers\Average::make()->label('Average Reach'),

                        ])
                        ->sortable(),
                ]),
                Tables\Columns\TextColumn::make('billboardOwner.name')
                    ->numeric()
                    ->sortable()->limit(30),
            ])

            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Add Billboard')
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        $query->where('booking_status', BookingStatus::Available);
                    })
                    ->preloadRecordSelect(true)
                    ->recordTitleAttribute('title'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->label('Remove'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()->label('Remove'),
                ]),
            ]);
    }

    public function form(Form $form): Form
    {
        return BillboardResource::form($form);
    }
}
