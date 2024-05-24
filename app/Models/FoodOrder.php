<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FoodOrder extends Model
{
    use HasFactory;
    protected $table = 'food_orders';

    protected $fillable = [];

    public function trip() : HasOne {
        return $this->hasOne(Trip::class, 'food_order_id', 'id');
    }
}
