<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * PostFilter
 */
class UserFilter extends QueryFilter
{
    public function is_active($status)
    {
        if ($status === 'true') {
            return $this->builder->where('active', 'Y');
        };
        return $this->builder->where('active', 'N');
    }

    public function last_login_from($date)
    {
        return $this->builder->where('last_login', '>=', $date);
    }

    public function last_login_to($date)
    {
        return $this->builder->where('last_login', '<=',  $date);
    }

    public function register_at_from($date)
    {
        return $this->builder->where('register_at', '>=',  $date);
    }

    public function register_at_to($date)
    {
        return $this->builder->where('register_at', '<=',  $date);
    }

    public function search($text)
    {
        return $this->builder->where(function (Builder $query) use ($text) {
            $query->where('email', 'ILIKE', "%{$text}%")
                ->orWhere('name', 'ILIKE', "%{$text}%")
                ->orWhere('last_name', 'ILIKE', "%{$text}%")
                ->orWhere('second_name', 'ILIKE', "%{$text}%");
        });
    }
}
