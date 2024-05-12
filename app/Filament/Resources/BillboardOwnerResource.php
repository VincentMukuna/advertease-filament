<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillboardOwnerResource\Pages;
use App\Models\BillboardOwner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BillboardOwnerResource extends Resource
{
    protected static ?string $model = BillboardOwner::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Details')->schema([
                            Forms\Components\TextInput::make('name')
                                ->required(),
                            Forms\Components\MarkdownEditor::make('bio')
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Contact')->schema([
                        Forms\Components\TextInput::make('website')
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->prefixIcon('heroicon-o-at-symbol')
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->prefixIcon('heroicon-o-phone')
                            ->required(),
                    ])->columnSpan(['lg' => 1]),
                ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('billboards_count')
                    ->label('Billboards')
                    ->numeric()
                    ->counts('billboards'),
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
            'index' => Pages\ListBillboardOwners::route('/'),
            'create' => Pages\CreateBillboardOwner::route('/create'),
            'edit' => Pages\EditBillboardOwner::route('/{record}/edit'),
        ];
    }
}
