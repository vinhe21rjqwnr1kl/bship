<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class TBookingSupplierServices extends Model
{
    use HasFactory;
    
    protected $table = 't_booking_supplier_services';
    protected $fillable = [
        'name',
        'description',
        'cost',
        'org_cost',
        'status',
        'booking_supplier_id',
        
	];
}
