<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'is_processed',
        'total',
        'payment_status',
        'status',
        'delivery_method',
        'delivery_date',
        'delivery_address',
        'delivery_company',
        'contact_name',
        'contact_phone',
        'website_comment',
        'website_comment_for_client',
        'latest_update_by_client',
        'payment_type',
        'is_delivery_today',
        'created_by',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function document_status()
    {
        return $this->belongsTo(DocumentStatus::class, 'status', 'guid');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }
}
