<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomenclature extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_guid', 'guid');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'nomenclature_guid', 'guid');
    }

    public function basket()
    {
        return $this->hasMany(Basket::class, 'nomenclature_guid', 'guid');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }
}
