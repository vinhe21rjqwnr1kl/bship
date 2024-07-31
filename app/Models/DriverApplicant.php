<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverApplicant extends Model
{
    use HasFactory;

    protected $table = 'driver_applicants';

    protected $fillable = [
        'full_name',
        'email',
        'date_of_birth',
        'phone_number',
        'current_address',
        'current_status',
        'current_city',
        'identification',
        'agree_to_share_info'
    ];
}
