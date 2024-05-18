<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use App\Enum\Billboard\BookingStatus;
use App\Filament\Resources\BillboardResource;
use App\Models\Billboard;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
                    ->using(function (Model $record, array $data, Tables\Actions\AttachAction $action) {
                        $campaign = $this->getOwnerRecord();
                        $startDate = Carbon::make($campaign->start_date);
                        $endDate = Carbon::make($campaign->end_date);
                        $campaignDuration = $startDate->diffInDays($endDate);
                        $budget = $campaign->budget;
                        $totalDailyRate = $campaign
                            ->billboards
                            ->map(fn (Billboard $billboard) => $billboard->daily_rate)
                            ->sum();
                        $attachedRate = Billboard::find($data['recordId'])->daily_rate;

                        $newTotal = ($totalDailyRate + $attachedRate) * $campaignDuration;

                        dd($newTotal.'-'.$budget);
                        if ($newTotal > $budget) {
                            Notification::make()
                                ->danger()
                                ->title("You've surpassed your campaign's budget by ".$newTotal - $budget)
                                ->body('Try increasing it first!')
                                ->send();
                            $action->halt();
                        }

                        return $action;
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
