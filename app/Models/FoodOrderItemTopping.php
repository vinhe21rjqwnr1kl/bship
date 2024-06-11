<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrderItemTopping extends Model
{
    use HasFactory;

    protected $table = 'food_order_item_toppings';

    public function topping()
    {
        return $this->belongsTo(Topping::class, 'topping_id');
    }
}
