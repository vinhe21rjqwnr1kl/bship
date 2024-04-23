<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class TBookingComments extends Model
{
    use HasFactory;
    
    protected $table = 't_booking_comments';
    protected $fillable = [
        'status',
        'title',
        'content',
        'comment_tag',
	];



}
