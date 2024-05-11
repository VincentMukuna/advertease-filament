<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class BillboardOwner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'bio',
        'website',
        'email',
        'phone',
        'social_media_links',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'social_media_links' => 'array',
    ];

    public function billboards(): HasMany
    {
        return $this->hasMany(Billboard::class);
    }

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }
}
