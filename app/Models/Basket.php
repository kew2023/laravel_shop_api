<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = ['created_by', 'nomenclature_guid', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class, 'nomenclature_guid', 'guid');
    }
}
