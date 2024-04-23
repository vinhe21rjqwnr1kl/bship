<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class TBookingSupplierImages extends Model
{
    use HasFactory;
    
    protected $table = 't_booking_supplier_images';
    protected $fillable = [
        'type',
        'image',
        'status',
        'booking_supplier_id',
	];
}
