<?php

namespace App\Services;

use App\Contracts\CampaignInvoiceHandler;
use App\DTO\CampaignInvoiceDTO;
use App\DTO\InvoiceItemDTO;
use App\Models\Campaign;

class CampaignInvoiceService implements CampaignInvoiceHandler
{
    public function buildCampaignInvoice(Campaign $campaign): CampaignInvoiceDTO
    {
        $campaign = $campaign->with('payments', 'billboards')->first();
        $amountDue = $this->calculateAmountDue($campaign);
        $totalPayments = $this->getTotalPayments($campaign);
        $balance = $amountDue - $totalPayments;

        $billboardsItem = new InvoiceItemDTO('Billboards', $campaign->billboards->sum('daily_rate'), $campaign->billboards->count());
        $items = [$billboardsItem];

        return new CampaignInvoiceDTO($campaign, $balance, $items, $amountDue, $totalPayments);

    }

    public function calculateAmountDue(Campaign $campaign): float
    {
        // calculate total due amount for duration of campaign
        $startDate = $campaign->start_date;
        $endDate = $campaign->end_date;
        $campaignDurationInDays = $startDate->diffInDays($endDate);

        // total rate for campaign
        $billboards = $campaign->billboards;

        $totalRate = 0;
        foreach ($billboards as $billboard) {
            $totalRate += $billboard->daily_rate;
        }

        return $totalRate * $campaignDurationInDays;
    }

    public function getTotalPayments(Campaign $campaign)
    {
        return $campaign->payments->sum('amount');
    }
}
