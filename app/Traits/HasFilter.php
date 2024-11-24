<?php

namespace App\Traits;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    //

    /**
     * Apply all relevant thread filters.
     */
    public function scopeFilter($query, Filter $filters): Builder
    {
        return $filters->apply($query);
    }
}
