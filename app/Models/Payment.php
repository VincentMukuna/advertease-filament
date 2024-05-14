<?php

namespace App\Models;

use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'reference',
        'provider',
        'method',
        'currency',
        'campaign_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'amount' => 'decimal:2',
        'campaign_id' => 'integer',
    ];

    protected static function booted(): void
    {

        static::addGlobalScope('brand', function (Builder $query) {
            if (auth()->user()) {
                if (auth()->user()->hasRole(UserRoleEnum::SuperAdmin)) {
                    return;
                }
                $query->whereIn('campaign_id', auth()->user()->brand->campaigns->pluck('id'));
            }
        });
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
