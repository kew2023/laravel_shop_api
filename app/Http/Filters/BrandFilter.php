<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * PostFilter
 */
class BrandFilter extends QueryFilter
{
    public function search($text)
    {
        return $this->builder->where(function (Builder $query) use ($text) {
            return $query->where('guid', 'ILIKE', "%{$text}%")
                ->orWhere('name', 'ILIKE', "%{$text}%");
        });
    }
}
