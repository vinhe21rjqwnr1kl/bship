<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $table = 'delivery_go_info';
//    protected $fillable = [];

    public function trip_request() : BelongsTo {
        return $this->belongsTo(TripRequest::class, 'go_request_id', 'id');
    }

    public function trip() : BelongsTo {
        return $this->belongsTo(Trip::class, 'go_id', 'id');
    }

}
