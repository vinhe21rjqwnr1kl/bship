<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class TBookingSuppliers extends Model
{
    use HasFactory;
    
    protected $table = 't_booking_suppliers';
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        
        'address_text',
        'lat',
        'lng',
        'service_id',
        'agency_id',
        'status',

	];
}
