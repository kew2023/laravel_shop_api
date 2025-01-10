<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class Brand extends Model
{
    use HasFactory;

    // Указываем, что primary key - это 'guid', а не 'id'
    protected $primaryKey = 'guid';

    // Указываем, что ключ 'guid' не является инкрементируемым
    public $incrementing = false;

    // Указываем тип данных для ключа
    protected $keyType = 'string';
    protected $fillable = [
        'guid',
        'name',
        'main_brand_guid'
    ];

    public function main_brand()
    {
        return $this->belongsTo(Brand::class, 'main_brand_guid', 'guid');
    }


    public function brands()
    {
        return $this->hasMany(Brand::class, 'main_brand_guid', 'guid');
    }

    public function nomenclatures()
    {
        return $this->hasMany(Nomenclature::class, 'brand_guid', 'guid');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }
}
