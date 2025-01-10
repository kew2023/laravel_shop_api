<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentStatus extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class, 'status', 'guid');
    }
}
