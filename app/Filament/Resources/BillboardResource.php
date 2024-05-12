<?php

namespace App\Filament\Resources;

use App\Enum\Billboard\BookingStatus;
use App\Filament\Resources\BillboardResource\Pages;
use App\Models\Billboard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                    ->limit(30)
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('billboardOwner.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('booking_status')
                    ->icon(fn (BookingStatus $state) => match ($state) {
                        BookingStatus::Available => 'heroicon-o-check-circle',
                        BookingStatus::Booked => 'heroicon-o-x-circle',
                    })
                    ->label('Available')
                    ->searchable(),
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
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation(),
            ])
            ->groups([
                Tables\Grouping\Group::make('billboardOwner.name')
                    ->label('Billboard Owner')
                    ->collapsible(),
                Tables\Grouping\Group::make('created_at')
                    ->label('Created At')
                    ->date()
                    ->collapsible(),
                Tables\Grouping\Group::make('Type')
                    ->label('Type')
                    ->collapsible(),
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
