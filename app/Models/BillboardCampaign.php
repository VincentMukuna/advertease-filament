<?php

namespace App\Models;

use App\Enum\Campaign\BillboardCampaignStatus;
use App\Observers\BillboardCampaignObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([BillboardCampaignObserver::class])]
class BillboardCampaign extends Pivot
{
    public $incrementing = true;

    protected $guarded = [];

    public function billboard(): BelongsTo
    {
        return $this->belongsTo(Billboard::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    protected function casts(): array
    {
        return [
            'status' => BillboardCampaignStatus::class,
            'active_at' => 'datetime',
        ];
    }
}
