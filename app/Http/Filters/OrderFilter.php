<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * PostFilter
 */
class OrderFilter extends QueryFilter
{
    public function statuses($statuses)
    {
        return $this->builder->whereIn('status', $statuses);
    }

    public function payment_statuses($paymentStatuses)
    {
        return $this->builder->whereIn('payment_status', $paymentStatuses);
    }

    public function is_processed($status)
    {
        return $this->builder->where('is_processed',  $status);
    }

    public function users($users)
    {
        if (auth()->user()->role === 'admin') {
            return $this->builder->whereIn('created_by', $users);
        }
        return $this->builder;
    }

    public function latest_update_by_client($sort)
    {
        //  - asc | desc

        return $this->builder->orderBy('latest_update_by_client', $sort);
    }
}
