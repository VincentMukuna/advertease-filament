<?php

namespace App\Filament\Resources;

use App\Enum\Billboard\BookingStatus;
use App\Enum\Billboard\Size;
use App\Enum\Billboard\Type;
use App\Enum\UserRoleEnum;
use App\Filament\Resources\BillboardOwnerResource\RelationManagers\BillboardsRelationManager;
use App\Filament\Resources\BillboardResource\Pages;
use App\Filament\Resources\BillboardResource\RelationManagers\CampaignsRelationManager;
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
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Details')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required(),
                            Forms\Components\Select::make('billboard_owner_id')
                                ->relationship('billboardOwner', 'name')
                                ->default(function () {
                                    if (auth()->user()->hasRole(UserRoleEnum::BillboardOwner)) {
                                        return auth()->user()->billboardCompany->id;
                                    }

                                    return null;
                                })
                                ->hidden(auth()->user()->hasRole(UserRoleEnum::BillboardOwner))
                                ->required()
                                ->hiddenOn(BillboardsRelationManager::class),
                            Forms\Components\MarkdownEditor::make('description')
                                ->required()
                                ->columnSpanFull(),

                        ])->columns(2),
                    Forms\Components\Section::make('Stats')
                        ->schema([
                            Forms\Components\TextInput::make('daily_rate')
                                ->required()
                                ->numeric(),
                            Forms\Components\ToggleButtons::make('size')
                                ->inline()
                                ->options(Size::class)
                                ->required(),
                            Forms\Components\ToggleButtons::make('type')
                                ->inline()
                                ->options(Type::class)
                                ->required(),
                            Forms\Components\TextInput::make('reach')
                                ->numeric(),
                        ]),
                    Forms\Components\Section::make('Images')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                                ->collection('billboard-images')
                                ->multiple()
                                ->maxFiles(5)
                                ->hiddenLabel(),
                        ])
                        ->collapsible(),

                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Toggle::make('is_visible')
                        ->required(),
                    Forms\Components\ToggleButtons::make('booking_status')
                        ->label('Booking Status')
                        ->options(BookingStatus::class)
                        ->inline()
                        ->required(),
                    Forms\Components\Section::make('Location')
                        ->schema([
                            Forms\Components\TextInput::make('lat')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('lng')
                                ->required()
                                ->numeric(),
                        ]),

                ])->columnSpan(['lg' => 1]),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('billboard-image')
                    ->label('Image')
                    ->alignCenter()
                    ->collection('billboard-images'),
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
            ->defaultSort('id', 'desc')
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
            CampaignsRelationManager::class,
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
