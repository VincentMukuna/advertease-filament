<?php

namespace App\Filament\Resources;

use App\Enum\UserRoleEnum;
use App\Filament\Resources\BrandResource\RelationManagers\CampaignsRelationManager;
use App\Filament\Resources\CampaignResource\Pages;
use App\Filament\Resources\CampaignResource\RelationManagers\BillboardsRelationManager;
use App\Filament\Resources\CampaignResource\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\CampaignResource\Widgets\CampaignOverview;
use App\Models\Campaign;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...static::getDetails(),
                ...static::getDurationDetails(),
                ...static::getStats(),
                ...static::getBrandDetails(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('starting_from')
                            ->placeholder(fn ($state): string => 'Dec 18, '.now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('ending_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['starting_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['ending_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['starting_from'] ?? null) {
                            $indicators['starting_from'] = 'Campaigns from '.Carbon::parse($data['starting_from'])->toFormattedDateString();
                        }
                        if ($data['end_until'] ?? null) {
                            $indicators['end_until'] = 'Campaign until '.Carbon::parse($data['end_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
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

    public static function getDetails(): array
    {
        return [

            Tables\Columns\ColumnGroup::make('Details')
                ->columns([
                    Tables\Columns\TextColumn::make('number')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('title')
                        ->limit(30)
                        ->searchable(),
                    Tables\Columns\SpatieMediaLibraryImageColumn::make('campaign-images')
                        ->label('Image')
                        ->alignCenter()
                        ->collection('campaign-images'),

                ]),

        ];
    }

    public static function getDurationDetails(): array
    {
        return [

            Tables\Columns\ColumnGroup::make('Stats')
                ->columns([
                    Tables\Columns\TextColumn::make('start_date')
                        ->date()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('end_date')
                        ->date()
                        ->sortable(),

                ]),

        ];
    }

    public static function getStats(): array
    {
        return [
            Tables\Columns\TextColumn::make('target_audience')
                ->limit(25)
                ->searchable(),
            Tables\Columns\TextColumn::make('budget')
                ->numeric()
                ->summarize([
                    Tables\Columns\Summarizers\Sum::make(),
                    Tables\Columns\Summarizers\Average::make(),
                ])
                ->sortable(),

        ];
    }

    public static function getBrandDetails(): array
    {
        return [

            Tables\Columns\ColumnGroup::make('Brand Details')
                ->columns([
                    Tables\Columns\TextColumn::make('brand.name')
                        ->label('Name')
                        ->limit(30)
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('brand.email')
                        ->label('Email')
                        ->limit(30)
                        ->numeric()
                        ->sortable(),

                ]),

        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\TextInput::make('number')
                        ->label('Campaign Number')
                        ->default('CAM-'.random_int(100000, 999999))
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->maxLength(32)
                        ->unique(Campaign::class, 'number', ignoreRecord: true),
                    Forms\Components\Section::make('Details')->schema([
                        Forms\Components\TextInput::make('title')
                            ->required(),
                        Forms\Components\TextInput::make('target_audience')
                            ->required(),
                        Forms\Components\MarkdownEditor::make('objective')
                            ->required()
                            ->columnSpanFull(),

                    ])->columns(2),

                    Forms\Components\Section::make('Images')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                                ->collection('campaign-images')
                                ->multiple()
                                ->maxFiles(5)
                                ->hiddenLabel(),
                        ])
                        ->collapsible(),

                ])->columns(2)->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->default(function () {
                                if (auth()->user()->hasRole(UserRoleEnum::Advertiser)) {
                                    return auth()->user()->brand->id;
                                }

                                return null;
                            })
                            ->hidden(function () {
                                return auth()->user()->hasRole(UserRoleEnum::Advertiser);
                            })
                            ->required()
                            ->hiddenOn(CampaignsRelationManager::class),
                        Forms\Components\TextInput::make('budget')
                            ->required()
                            ->numeric(),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->required(),
                            ]),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (Campaign $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn (Campaign $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Campaign $record) => $record === null),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);

    }

    public static function getRelations(): array
    {
        return [
            PaymentsRelationManager::class,
            BillboardsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CampaignOverview::class,
        ];
    }
}
