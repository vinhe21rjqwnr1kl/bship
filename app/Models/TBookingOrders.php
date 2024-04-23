<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class TBookingOrders extends Model
{
    use HasFactory;
    
    protected $table = 't_booking_orders';
    protected $fillable = [
        'status_order',
        'request_time'
	];



}
