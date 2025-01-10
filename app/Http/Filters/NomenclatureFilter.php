<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * PostFilter
 */
class NomenclatureFilter extends QueryFilter
{
    public function brands($array)
    {
        return $this->builder->whereIn('brand_guid', $array);
    }

    public function search($text)
    {
        return $this->builder->where(function (Builder $query) use ($text) {
            return $query->where('code', 'ILIKE', "%{$text}%")
                ->orWhere('name', 'ILIKE', "%{$text}%")
                ->orWhere('full_name', 'ILIKE', "%{$text}%")
                ->orWhere('set_number', 'ILIKE', "%{$text}%");
        });
    }
}
