<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Stevebauman\Purify\Facades\Purify;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'go_info';
    protected $fillable = [
		'service_detail_id',
        'service_id',
        'pickup_address',
        'pickup_place_id',
        'pickup_date',
        'pickup_time',
        'drop_address',
        'drop_place_id',
        'drop_time',
        'drop_date',
        'progress',
        'cost',
        'driver_cost',
        'butl_cost',
        'user_id',
		'driver_id',
        'create_date',
        'go_request_id',
        'discount_from_code',
        'service_cost',
        'feedback',
        'is_show_app'

	];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function trip_request() : BelongsTo
    {
        return $this->belongsTo(TripRequest::class);
    }

    public function food_ordeṛ() : BelongsTo {
        return $this->belongsTo(FoodOrder::class, 'food_order_id', 'id');
    }

    public function delivery_order() : HasOne {
        return $this->hasOne(DeliveryOrder::class, 'go_id', 'id');
    }




}
