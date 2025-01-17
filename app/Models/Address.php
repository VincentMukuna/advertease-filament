<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'additional_info',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function addressables(): MorphToMany
    {
        return $this->morphedByMany(Addressable::class, 'addressable');
    }

    public function brands(): MorphToMany
    {
        return $this->morphedByMany(Brand::class, 'addressable');
    }

    public function billboardOwners(): MorphToMany
    {
        return $this->morphedByMany(BillboardOwner::class, 'addressable');
    }
}
