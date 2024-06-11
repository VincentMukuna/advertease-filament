<?php

namespace App\Actions\Billboard;

use App\DTO\MaintenanceScheduleDTO;
use App\Enum\Campaign\BillboardCampaignStatus;
use App\Models\Billboard;
use App\Models\BillboardCampaign;
use App\Notifications\BillboardCampaign\CampaignBillboardMaintenanceEnd;
use App\Notifications\BillboardCampaign\CampaignBillboardMaintenanceStart;

class BillboardMaintenance
{
    public static function schedule(Billboard $billboard, MaintenanceScheduleDTO $schedule): void
    {
        if ($billboard->maintenances()->ongoing()->exists()) {
            return;
        }
        $billboard->update(['is_visible' => false]);
        $activeCampaigns = $billboard->campaigns()->ongoing()->get();

        $billboard->maintenances()->create([
            'start_date' => $schedule->start_date,
            'end_date' => $schedule->end_date,
        ]);

        $activeCampaigns->map(function ($activeCampaign) use ($billboard, $schedule) {
            $billboardCampaign = BillboardCampaign::query()->where([
                ['billboard_id', $billboard->id],
                ['campaign_id', $activeCampaign->id],
            ])->first();

            if ($billboardCampaign) {
                $billboardCampaign->update(['status' => BillboardCampaignStatus::Maintenance]);
                $activeCampaign
                    ->brand
                    ->user
                    ->notify(
                        new CampaignBillboardMaintenanceStart($billboardCampaign, $schedule)
                    );
            }
        });
    }

    public static function end(Billboard $billboard): void
    {
        $billboard->update(['is_visible' => true]);

        $activeCampaigns = $billboard->campaigns()->ongoing()->get();

        $maintenance = $billboard->maintenances()->ongoing()->first();

        if ($maintenance->end_date > today()) {

            $maintenance->update(['end_date' => now()->subMinutes(2)]);
        }

        //notify brands of maintenance end
        foreach ($activeCampaigns as $activeCampaign) {
            $billboardCampaign = BillboardCampaign::query()->where([
                ['billboard_id', $billboard->id],
                ['campaign_id', $activeCampaign->id],
            ])->first();

            if ($billboardCampaign) {
                $billboardCampaign->update(['status' => BillboardCampaignStatus::Active]);
                $activeCampaign
                    ->brand
                    ->user
                    ->notify(
                        new CampaignBillboardMaintenanceEnd($billboardCampaign)
                    );
            }
        }

    }
}
