<?php

namespace App\Actions\Billboard;

use App\Enum\Campaign\BillboardCampaignStatus;
use App\Models\BillboardCampaign;
use App\Notifications\BillboardCampaign\BillboardPrinted;

class PrintBillboard
{
    public static function print(BillboardCampaign $billboardCampaign): void
    {
        $billboard = $billboardCampaign->billboard;
        $campaign = $billboardCampaign->campaign;

        $billboardCampaign->status = BillboardCampaignStatus::Installing;
        $billboardCampaign->save();

        $campaign->brand->user->notify(
            new BillboardPrinted($billboard, $campaign)
        );

    }
}
