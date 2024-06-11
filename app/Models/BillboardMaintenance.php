<?php

namespace App\Models;

use App\Concerns\HasDuration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillboardMaintenance extends Model
{
    use HasDuration;

    protected $table = 'billboard_maintenance';

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    protected $guarded = [];

    public function billboard(): BelongsTo
    {
        return $this->belongsTo(Billboard::class);
    }
}
