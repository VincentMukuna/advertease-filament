<?php

namespace App\Models;

use App\Enum\Billboard\BookingStatus;
use App\Enum\Billboard\Size;
use App\Enum\Billboard\Type;
use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Billboard extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'daily_rate',
        'size',
        'type',
        'is_visible',
        'booking_status',
        'lat',
        'lng',
        'reach',
        'billboard_owner_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'booking_status' => BookingStatus::class,
        'size' => Size::class,
        'type' => Type::class,
        'id' => 'integer',
        'daily_rate' => 'decimal:2',
        'is_visible' => 'boolean',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'billboard_owner_id' => 'integer',
    ];

    protected static function booted(): void
    {

        static::addGlobalScope('own', function (Builder $query) {
            if (auth()->user()) {
                if (auth()->user()->hasRole(UserRoleEnum::BillboardOwner)) {
                    $query->where('billboard_owner_id', auth()->user()->billboardCompany->id);
                }
            }
        });
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class)->using(BillboardCampaign::class);
    }

    public function billboardOwner(): BelongsTo
    {
        return $this->belongsTo(BillboardOwner::class);
    }
}
