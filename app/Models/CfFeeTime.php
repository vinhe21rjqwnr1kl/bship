<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class CfFeeTime extends Model
{
    use HasFactory;
    
    protected $table = 'cf_fee_time';
    protected $fillable = [
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'service_detail_id',
        'time_type',
        'index_fee_id',
        'day_of_week',
        'priority',
        'fee_type',
        'fee',
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

  


}
