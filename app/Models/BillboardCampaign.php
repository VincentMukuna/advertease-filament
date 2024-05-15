<?php

namespace App\Models;

use App\Enum\Campaign\BillboardCampaignStatus;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BillboardCampaign extends Pivot
{
    public $incrementing = true;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => BillboardCampaignStatus::class,
        ];
    }
}
