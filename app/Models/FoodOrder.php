<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FoodOrder extends Model
{
    use HasFactory;
    protected $table = 'food_orders';

    protected $fillable = [];

    public function trip() : HasOne {
        return $this->hasOne(Trip::class, 'food_order_id', 'id');
    }

    public function tripRequest() : HasOne {
        return $this->hasOne(TripRequest::class, 'food_order_id', 'id');
    }

    public function restaurant() : BelongsTo {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }

    public function items() : HasMany {
        return $this->hasMany(FoodOrderItem::class, 'food_order_id', 'id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(UserB::class, 'user_id', 'id');
    }

    public function driver() : BelongsTo {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
