<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BindsDynamically;

class CustomModule extends Model
{
    use BindsDynamically;

    /**
     * Scope a query to only include active data.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }
}
