<?php

namespace App\Actions\Billboard;

use App\Enum\Campaign\BillboardCampaignStatus;
use App\Models\BillboardCampaign;
use App\Notifications\BillboardCampaign\CampaignBillboardActivated;

class ActivateCampaignBillboard
{
    public static function activate(BillboardCampaign $billboardCampaign)
    {
        $billboardCampaign->status = BillboardCampaignStatus::Active;
        $billboardCampaign->active_at = now();
        $billboardCampaign->save();

        $campaignUser = $billboardCampaign->campaign->brand->user;

        $campaignUser->notify(
            new CampaignBillboardActivated($billboardCampaign)
        );

    }
}
