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

    const COMPLETE = 3; // complete trip
    const FAIL = 4; // trip fail
    const CANCEL = 5; // driver canceled trip

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
        'is_show_app',
        'money_vat',
        'created_by',
        'order_id_gsm'
	];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function driver() : BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id')->withDefault();
    }

    public function trip_request() : BelongsTo
    {
        return $this->belongsTo(TripRequest::class, 'go_request_id', 'id');
    }

    public function food_order() : BelongsTo {
        return $this->belongsTo(FoodOrder::class, 'food_order_id', 'id');
    }

    public function delivery_order() : HasOne {
        return $this->hasOne(DeliveryOrder::class, 'go_id', 'id');
    }

    public function discount_used() : HasOne {
        return $this->hasOne(VoucherUsed::class, 'go_info_id', 'id');
    }
}
