<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasDuration
{
    public function scopeOngoing(Builder $query): Builder
    {
        return $query
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>', now());
    }

    public function scopeEnded(Builder $query): Builder
    {
        return $query
            ->whereDate('end_date', '<=', now());
    }
}
