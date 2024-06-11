<?php

namespace App\Observers;

use App\Models\BillboardCampaign;
use App\Notifications\BillboardCampaign\BillboardAttachedToCampaign;

class BillboardCampaignObserver
{
    /**
     * Handle the BillboardCampaign "created" event.
     */
    public function created(BillboardCampaign $billboardCampaign): void
    {
        $billboard = $billboardCampaign->billboard;
        $campaign = $billboardCampaign->campaign;
        $billboard->billboardOwner->user->notify(
            new BillboardAttachedToCampaign($billboard, $campaign)
        );
    }

    /**
     * Handle the BillboardCampaign "updated" event.
     */
    public function updated(BillboardCampaign $billboardCampaign): void
    {
        //
    }

    /**
     * Handle the BillboardCampaign "deleted" event.
     */
    public function deleted(BillboardCampaign $billboardCampaign): void
    {
        //
    }

    /**
     * Handle the BillboardCampaign "restored" event.
     */
    public function restored(BillboardCampaign $billboardCampaign): void
    {
        //
    }

    /**
     * Handle the BillboardCampaign "force deleted" event.
     */
    public function forceDeleted(BillboardCampaign $billboardCampaign): void
    {
        //
    }
}
