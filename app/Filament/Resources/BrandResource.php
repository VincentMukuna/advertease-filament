<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Details')->schema([
                            Forms\Components\TextInput::make('name')

                                ->required(),
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')
                                ->unique('brands', ignoreRecord: true)
                                ->required()
                                ->native(false)
                                ->placeholder('Select a user')
                                ->searchable()
                                ->prefixIcon('heroicon-o-user'),
                            Forms\Components\MarkdownEditor::make('bio')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Contact')->schema([
                        Forms\Components\TextInput::make('website')
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->url(),
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
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\TextColumn::make('name')
                        ->searchable(),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('phone')
                            ->icon('heroicon-m-phone'),
                        Tables\Columns\TextColumn::make('email')
                            ->icon('heroicon-m-envelope'),
                    ]), ]),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
