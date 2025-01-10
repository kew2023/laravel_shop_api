<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $primaryKey = ['order_id', 'nomenclature_guid'];  // Укажите имя вашей колонки, если это не 'id'
    public $incrementing = false;  // Если ваш ключ не автоинкрементируется
    protected $table = 'orders_items';
    protected $fillable = [
        "order_id",
        "amount",
        "nomenclature_guid",
        "price",
        "discount"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class, 'nomenclature_guid', 'guid');
    }
}
