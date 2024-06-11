<?php

namespace App\Contracts;

use App\DTO\CampaignInvoiceDTO;
use App\Models\Campaign;

interface CampaignInvoiceHandler
{
    public function buildCampaignInvoice(Campaign $campaign): CampaignInvoiceDTO;
}
