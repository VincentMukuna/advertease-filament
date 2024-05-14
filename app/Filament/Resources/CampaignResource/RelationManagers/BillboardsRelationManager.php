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

    public function form(Form $form): Form
    {
        return BillboardResource::form($form);
    }

    public function table(Table $table): Table
    {
        return BillboardResource::table($table)
            ->filters([
                //
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
}
