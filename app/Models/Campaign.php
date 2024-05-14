<?php

namespace App\Models;

use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'brand_id' => 'integer',

    ];

    protected static function booted(): void
    {

        static::addGlobalScope('brand', function (Builder $query) {
            if (auth()->user()) {
                if (auth()->user()->hasRole(UserRoleEnum::SuperAdmin)) {
                    return;
                }
                $query->where('brand_id', auth()->user()->brand->id);
            }
        });
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function billboards(): BelongsToMany
    {
        return $this->belongsToMany(Billboard::class);
    }

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }
}
