<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodOrderItem extends Model
{
    use HasFactory;

    protected $table = 'food_order_items';
    protected $fillable = [];

    protected $appends = ['total_price'];

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }
    public function product() : BelongsTo {
        return $this->belongsTo(FoodProduct::class, 'food_product_id', 'id');
    }

    public function size() : BelongsTo {
        return $this->belongsTo(FoodProductSize::class, 'food_product_size_id', 'id');
    }

    public function food_order_item_toppings()
    {
        return $this->hasMany(FoodOrderItemTopping::class, 'food_order_item_id');
    }


}
