<?php

namespace App\Filament\Resources\BillboardResource\Pages;

use App\Actions\Billboard\BillboardMaintenance;
use App\DTO\MaintenanceScheduleDTO;
use App\Filament\Resources\BillboardResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Carbon;

class EditBillboard extends EditRecord
{
    protected static string $resource = BillboardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Schedule Maintenance')
                ->color('warning')
                ->icon('heroicon-o-wrench')
                ->form([
                    DatePicker::make('start_date')->default(now())->required(),
                    DatePicker::make('end_date')->minDate(function (Get $get) {
                        return Carbon::make($get('start_date'))->addDay();
                    })->required(),
                ])
                ->action(function (array $data) {
                    BillboardMaintenance::schedule(
                        $this->getRecord(),
                        new MaintenanceScheduleDTO($data['start_date'], $data['end_date'])
                    );
                })
                ->successNotificationTitle('Maintenance scheduled')
                ->modalWidth(MaxWidth::Medium)
                ->visible(fn () => ! ($this->getRecord()->maintenances()->ongoing()->exists())),
            Actions\Action::make('End Maintenance')
                ->color('info')
                ->icon('heroicon-o-rocket-launch')
                ->action(function () {
                    BillboardMaintenance::end($this->getRecord());
                })
                ->visible(fn () => $this->getRecord()->maintenances()->ongoing()->exists()),
        ];
    }
}
