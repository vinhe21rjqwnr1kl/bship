<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TripRequest extends Model
{
    use HasFactory;

    protected $table = 'go_request';
    protected $fillable = [
//        'service_id',
//        'service_detail_id',
//        'pickup_address',
//        'pickup_latitude',
//        'pickup_longitude',
//        'pickup_place_id',
//        'pickup_time',
//        'pickup_date',
//        'drop_address',
//        'drop_latitude',
//        'drop_longitude',
//        'drop_place_id',
//        'drop_time',
//        'drop_date',
//        'progress',
//        'cancel_reason',
//        'gift_code',
//        'original_code',
//        'discount_code',
//        'cost',
//        'driver_cost',
//        'butl_cost',
        'status',
//        'create_date',
    ];

    /**
     * Blog belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function trip()
    {
        return $this->hasOne(Trip::class, 'go_request_id', 'id');
    }

    public function delivery_order() : HasOne {
        return $this->hasOne(DeliveryOrder::class, 'go_request_id', 'id');
    }

    public function scopeUpdateFailedOrders(Builder $query)
    {
        $now = Carbon::now();
        $tenMinutesAgo = $now->copy()->subMinutes(3);
        $tenDaysAgo = $now->copy()->subDays(10);

        $tripRequests = TripRequest::where(function ($query) use ($tenMinutesAgo, $tenDaysAgo) {
            $query->whereIn('status', [0, 1, 2])
                ->whereBetween('create_date', [$tenDaysAgo, $tenMinutesAgo]);

        })
            ->with('trip')
            ->get();

        foreach ($tripRequests as $tripRequest) {
            if ($tripRequest->status == 0) {
                if ($tripRequest->trip) {
                    $tripRequest->update(['status' => 2]);
                } else {
                    $tripRequest->update(['status' => 1]);
                }
            } else if ($tripRequest->status == 2 && !$tripRequest->trip) {
                $tripRequest->update(['status' => 1]);
            } else if ($tripRequest->status == 1 && $tripRequest->trip) {
                $tripRequest->update(['status' => 2]);
            }
        }

        return $query;
    }


}
