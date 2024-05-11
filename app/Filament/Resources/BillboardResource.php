<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillboardResource\Pages;
use App\Filament\Resources\BillboardResource\RelationManagers;
use App\Models\Billboard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BillboardResource extends Resource
{
    protected static ?string $model = Billboard::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('daily_rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('size')
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\Toggle::make('is_visible')
                    ->required(),
                Forms\Components\TextInput::make('booking_status')
                    ->required(),
                Forms\Components\TextInput::make('lat')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('lng')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('reach')
                    ->numeric(),
                Forms\Components\Select::make('billboard_owner_id')
                    ->relationship('billboardOwner', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daily_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('booking_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lng')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reach')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('billboardOwner.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBillboards::route('/'),
            'create' => Pages\CreateBillboard::route('/create'),
            'edit' => Pages\EditBillboard::route('/{record}/edit'),
        ];
    }
}
