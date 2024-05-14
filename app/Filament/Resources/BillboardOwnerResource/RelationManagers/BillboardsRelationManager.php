<?php

namespace App\Filament\Resources\BillboardOwnerResource\RelationManagers;

use App\Filament\Resources\BillboardResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

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
