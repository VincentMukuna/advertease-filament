<?php

namespace App\DTO;

use App\Models\Campaign;

class CampaignInvoiceDTO
{
    /**
     * CampaignInvoiceDTO constructor.
     *
     * @param  InvoiceItemDTO[]  $items
     */
    public function __construct(
        public Campaign $campaign,
        public float $balance,
        public array $items,
        public float $totalAmountDue,
        public float $totalAmountPaid,
    ) {

    }
}
